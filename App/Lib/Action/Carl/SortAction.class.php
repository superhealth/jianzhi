<?php
class SortAction extends BaseAction{
	/**
	 * 所有分类
	 */
	public function index(){
		$sort = M("sort");
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['sort_name'] = array("like", "%".$_REQUEST['words']."%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $sort->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "sort_order";
		$field = "sort_id, sort_name, sort_order, IFNULL(enums,0) enums, IFNULL(base,0) base";
		//连接查询子类表，获取子分类数 base, 总子类数 enums
		$join = "LEFT JOIN (SELECT es_sort_id,count(*) enums from zt_enumsort GROUP BY es_sort_id) b ON sort_id=b.es_sort_id LEFT JOIN (SELECT es_sort_id,count(*) base from (SELECT es_sort_id, count(*) bases from zt_enumsort GROUP BY es_base) a group by a.es_sort_id) c ON sort_id = c.es_sort_id";
		$sorts = $sort->field($field)->join($join)->where($map)->order($order)->select();
		$this->assign("sorts", $sorts);
		$this->display();
	}
	
	/**
	 * 添加主类
	 */
	public function sort_add($action=""){
		if($action=="add"){
			if(!per_check("sort_edit")){
				$this->error("无此权限！");
			}
			$data = M("sort")->create();
			if(M("sort")->add($data)){
				$this->watchdog("新增", "添加新主类：{$data['sort_name']}");
				$this->success("添加成功！");
			}else{
				$this->error("添加失败！");
			}
		}else{
			if(!per_check("sort_edit")){
				response_msg("无此权限！", "error", true);exit;
			}
			$responseHtml = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加主类别</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sort_name">类别名称</label>
						<div class="controls">
							 <input type="text" id="sort_name" name="sort_name" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sort_order">显示次序</label>
						<div class="controls">
						  	<input type="text" id="sort_order" name="sort_order" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHtml);
		}
	}
	
	/**
	 * 编辑主类
	 */
	public function sort_edit($action=""){
		if($action=="edit"){
			if(!per_check("sort_edit")){
				$this->error("无此权限！");
			}else{
				$data = M("sort")->create();
				if(M("sort")->save($data)){
					$this->watchdog("编辑", "修改主类别 <strong>{$data['sort_name']}</strong>");
					$this->success("修改成功！", __URL__."/index");
				}else{
					$this->error("修改失败！");
				}
			}
		}else{
			if(!per_check("sort_edit")){
				response_msg("无此权限！", "error", true);
				exit;
			}
			$responseHtml = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="sort_id" value="%id%" />	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改主类别</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sort_name">类别名称</label>
						<div class="controls">
							 <input type="text" id="sort_name" name="sort_name" value="%name%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sort_order">显示次序</label>
						<div class="controls">
						  	<input type="text" id="sort_order" name="sort_order" value="%order%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$info = M("sort")->where("sort_id={$_REQUEST['id']}")->find();
			if($info){
				echo str_replace(array("%id%", "%name%", "%order%", "%url%"), array($info['sort_id'], $info['sort_name'],$info['sort_order'],__ACTION__), $responseHtml);
			}else{
				echo response_msg("参数错误！", "error", true);
			}
		}
	}
	
	/**
	 * 删除主类
	 * @param string $chkt 选中的ID
	 */
	public function sort_delete($chkt=""){
		if(!per_check('sort_edit')){
			$this->error('无此权限！');
		}
		$map = array(
			"sort_id"	=> array("in",$chkt)
		);
		$sorts = M("sort")->where($map)->getField("sort_name", true);
		if(M("sort")->where($map)->delete()){
			$this->watchdog("删除", "删除主分类<strong>".implode("</strong>, <strong>", $sorts)."</strong>");
			$this->success("删除成功！");
		}else{
			$this->error("删除失败！");
		}
	}
	/**
	 * 主类详细信息
	 * @param string $id 主类ID
	 */
	public function sort_info($id=""){
		$sortInfo = M("sort")->where("sort_id={$id}")->find();
		$enums = M("enumsort")->where("es_sort_id={$id}")->select();
		$sortInfo['enum'] = count($enums);
		$enumNew = array();
		foreach($enums as $v){
			$enumNew[$v['es_base']][] = $v;
		}
		$sortInfo['base'] = count($enumNew);
		$this->assign("sortInfo", $sortInfo);
		$this->assign("enumNew", $enumNew);
		$this->display();
	}
	/**
	 * 添加类型
	 * @param string $action 
	 */
	public function enum_add($action=""){
		if($action=="add"){
			if(!per_check("enum_edit")){
				$this->error("无此权限！");
			}
			$data = M("enumsort")->create();
			if(M("enumsort")->add($data)){
				$sort_name = M("sort")->where("sort_id={$data['es_sort_id']}")->getfield("sort_name");
				$this->watchdog("新增", "添加新子类<strong>{$data['es_name']}</strong>,属于 <i>{$sort_name}</i> 下的 [{$data['es_base']}]");
				$this->success("添加成功！");
			}else{
				$this->error("添加失败！");
			}
		}else{
			if(!per_check("enum_edit")){
				echo response_msg("无此权限！", "error", true);exit;
			}
			$base = isset($_REQUEST['base']) ? $_REQUEST['base'] : "";
			$responseHtml = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加次级类别</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sort">从属分类</label>
						<div class="controls">
							 <input type="text" id="sort"  disabled="disabled" value="%sort%" />
							 <input type="hidden" name="es_sort_id" value="%id%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_name">分类名称</label>
						<div class="controls">
						  	<input type="text" id="es_name" name="es_name" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_order">分类排序</label>
						<div class="controls">
						  	<input type="text" id="es_order" name="es_order" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_base">分类依据</label>
						<div class="controls">
						  	<input type="text" id="es_base" name="es_base" value="%base%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			
			$sort_name = M("sort")->where("sort_id={$_REQUEST['id']}")->getfield("sort_name");
			echo str_replace(array("%sort%", "%id%", "%base%", "%url%"),array($sort_name, $_REQUEST['id'], $base, __ACTION__), $responseHtml);
		}
	}
	/**
	 * 编辑类型
	 * @param string $action 
	 */
	public function enum_edit($action=""){
		if($action=="edit"){
			if(!per_check("enum_edit")){
				$this->error("无此权限！");
			}else{
				$data = M("enumsort")->create();
				if(M("enumsort")->save($data)){
					$this->watchdog("编辑", "修改 [{$data['es_base']}]子类的<strong>{$data['es_name']}</strong>");
					$this->success("修改成功!");
				}else{
					$this->error("修改失败！");
				}
			}
		}else{
			if(!per_check("enum_edit")){
				echo response_msg("无此权限！", "error", true);exit;
			}
			$responseHtml = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="es_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加次级类别</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sort">从属分类</label>
						<div class="controls">
							 <input type="text" id="sort"  disabled="disabled" value="%sort%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_name">分类名称</label>
						<div class="controls">
						  	<input type="text" id="es_name" name="es_name" value="%name%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_order">分类排序</label>
						<div class="controls">
						  	<input type="text" id="es_order" name="es_order" value="%order%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_base">分类依据</label>
						<div class="controls">
						  	<input type="text" id="es_base" name="es_base" value="%base%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$info = M("enumsort")->field("es_id, es_name, es_order, es_base, sort_name")->join("zt_sort ON es_sort_id=sort_id")->where("es_id={$_REQUEST['id']}")->find();
			if($info){
				echo str_replace(array("%id%", "%sort%", "%name%", "%order%", "%base%", "%url%"),array($info['es_id'], $info['sort_name'], $info['es_name'], $info['es_order'], $info['es_base'], __ACTION__), $responseHtml);
			}else{
				echo response_msg("参数错误！", "error", true);exit;
			}
		}
	}
	/**
	 * 删除类型
	 * @param string $chkt
	 */
	public function enum_delete($id=""){
		if(!per_check('enum_edit')){
			$this->error('无此权限！');
		}
		if($id){
			$info = M("enumsort")->field("es_name, es_order, es_base, sort_name")->join("sort ON es_sort_id=sort_id")->where("es_id={$id}")->find("sort_name");
			if(M("enumsort")->where("es_id={$id}")->delete()){
				$this->watchdog("删除", "删除子类<strong>{$info['es_name']}</strong>,属于 <i>{$info['sort_name']}</i> 下的 [{$info['es_base']}]");
				$this->success("删除成功！");
			}else{
				$this->error("删除失败!");
			}
		}
	}
	
	/**
	 * 更新分类信息缓存
	 */
	public function update(){
		if(!per_check('cache_update')){
			$this->error('无此权限！');
		}
		D("Sort")->updateCache();
		D("Enumsort")->updateCache();
		$this->success("更新完毕！");
	}
	
}

?>