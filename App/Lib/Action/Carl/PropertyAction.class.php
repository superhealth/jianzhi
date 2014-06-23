<?php
/**
 * 生产属性模块
 * @author Carl
 *
 */
class PropertyAction extends BaseAction{
	/**
	 * 所有生产属性
	 */
	public function index(){
		$prop = M("property");
		/* $map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['pp_name']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $prop->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager); */
		$order = "pp_order";
		$props = $prop->order($order)->select();
		$this->assign("props", $props);
		$this->display();
	}
	/**
	 * 添加生产属性
	 */
	public function add($action=""){
		if($action=="add"){
			if(!per_check("prop_edit")){
				$this->error("无此权限！");
			}
			$data = M("property")->create();
			if(M("property")->add($data)){
				$this->watchdog("新增", "添加生产属性【 {$data['pp_name']}】");
				$this->success("添加成功！", __URL__."/index");
			}else{
				$this->error("添加失败！");
			}
		}else{
			if(!per_check("prop_edit")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
				
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>新增生产属性</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="pp_name">生产属性名称</label>
						<div class="controls">
							 <input type="text" id="pp_name" name="pp_name" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="pp_order">排列顺序</label>
						<div class="controls">
						  	<input type="text" name="pp_order" id="pp_order" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHTML);
		}
	}
	
	/**
	 * 修改生产属性
	 * @param string $action
	 */
	public function edit($action = ""){
		if($action=="edit"){
			if(!per_check("prop_edit")){
				$this->error("无此权限！");
			}
			else{
				$data = M("property")->create();
				if(M("property")->save($data)){
					$this->watchdog("编辑", "修改生产属性【 {$data['pp_name']}】");
					$this->success("保存成功！", __URL__."/index");
				}else{
					$this->error("保存失败！");
				}
			}
		}else{
			if(!per_check("prop_edit")){
				echo response_msg("无此权限!", "error", true);
				exit;
			}
			if(!isset($_REQUEST['id'])){
				echo response_msg("参数错误！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="pp_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改生产属性</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="pp_name">生产属性名称</label>
						<div class="controls">
							 <input type="text" id="pp_name" name="pp_name" value="%name%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="pp_order">排列顺序</label>
						<div class="controls">
						  	<input type="text" name="pp_order" id="pp_order" value="%order%" />
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$info = M("property")->where("pp_id={$_REQUEST['id']}")->find();
			if(empty($info)){
				echo response_msg("参数错误!", "error", true);
				exit;
			}
			echo str_replace(array("%id%", "%name%","%order%", "%url%"), array($info['pp_id'], $info['pp_name'], $info['pp_order'], __ACTION__), $responseHTML);
		}
	}
	
	/**
	 * 删除生产属性
	 * @param string $id
	 */
	public function delete($id=""){
		if(!per_check("prop_edit")){
			$this->error("无此权限！");
		}else{
			$map = array("pp_id"=>array("in", $id));
			$props = M("property")->where($map)->getField("pp_name", true);
			$detail = "删除生产属性：".implode(",", $props);
			if(M("property")->where($map)->delete()){
				$this->watchdog("删除", $detail);
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}
		}
	}
}