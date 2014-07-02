<?php
class IndexAction extends BaseAction{
	/**
	 *  首页 
	 */
	public function index(){
		
		$loginInfo = M("log")->where("log_action='登录' AND log_user='{$_SESSION['user']}'")->order("log_time DESC")->limit(1,1)->select();
		$this->assign("loginInfo", $loginInfo[0]);
		$this->display();
	}
	
	/**
	 * 注销 
	 */
	public function logout(){
		unset($_SESSION['user']);
		redirect(__GROUP__."/Login");
	}
	
	/**
	 * 友情链接
	 */
	public function links(){
		$link = M("links");
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['link_name']  = array('like', "%{$words}%");
				$where['link_title']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $link->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "link_order";
		$links = $link->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($links as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/ig", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("links", $links);
		$this->display();
	}
	/**
	 * 添加友情链接
	 */
	public function links_add($action=""){
		if($action=="add"){
			if(!per_check("links_edit")){
				$this->error("无此权限！");
			}
			$data = M("links")->create();
			if(M("links")->add($data)){
				$this->watchdog("新增", "添加友情链接《{$data['link_name']}》");
				$this->success("添加《{$data['link_name']}》成功！", __URL__."/links");
			}else{
				$this->error("添加《{$data['link_name']}》失败！");
			}
		}else{
			if(!per_check("links_edit")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加友情链接</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="link_name">友情链接名称</label>
						<div class="controls">
							 <input type="text" id="link_name" name="link_name" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="link_order">显示次序</label>
						<div class="controls">
						  	<input type="text" id="link_order" name="link_order" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="link_href">友情链接地址</label>
						<div class="controls">
						  	<input type="text" id="link_href" name="link_href" value="http://" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="link_title">友情链接描述</label>
						<div class="controls">
						  	<textarea name="link_title" id="link_title" style="width:320px;height:100px;"></textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHTML);
		}
	}
	
	/**
	 * 修改友情链接
	 * @param string $man_id
	 */
	public function links_edit($action = ""){
		if($action=="edit"){
			if(!per_check("links_edit")){
				$this->error("无此权限！");
			}else{
				$data = M("links")->create();
				if(M("links")->save($data)){
					$this->watchdog("编辑", "修改友情链接《{$data['link_name']}》");
					$this->success("修改成功！", __URL__."/links");
				}else{
					$this->error("修改失败！");
				}
			}
		}else{
			if(!per_check("links_edit")){
				echo response_msg("无此权限!", "error", true);
				exit;
			}
			if(!isset($_REQUEST['id'])){
				echo response_msg("参数错误！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="link_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改友情链接信息</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="link_name">友情链接名称</label>
						<div class="controls">
							 <input type="text" id="link_name" name="link_name" value="%name%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="link_order">排列次序</label>
						<div class="controls">
						  	<input type="text" id="link_order" name="link_order" value="%order%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="link_href">友情链接地址</label>
						<div class="controls">
						  	<input type="text" id="link_href" name="link_href" value="%href%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="link_title">友情链接描述</label>
						<div class="controls">
						  	<textarea name="link_title" id="link_title" style="width:320px;height:100px;">%desc%</textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$info = M("links")->where("link_id={$_REQUEST['id']}")->find();
			if(empty($info)){
				echo response_msg("参数错误!", "error", true);
				exit;
			}
			echo str_replace(array("%id%", "%name%", "%order%", "%href%","%desc%","%url%"), array($info['link_id'], $info['link_name'], $info['link_order'], $info['link_href'], $info['link_title'], __ACTION__), $responseHTML);
		}
	}
	
	/**
	 * 更新缓存
	 */
	public function links_update(){
		if(!per_check("links_edit")){
			$this->error("无此权限！");
		}
		if(D("Links")->updateCache()){
			$this->success("更新成功！");
		}else{
			$this->error("更新失败！");
		}
	}
	
	/**
	 * 删除友情链接
	 * @param string $chkt
	 */
	public function links_delete($chkt=""){
		if(!per_check("links_edit")){
			$this->error("无此权限！");
		}else{
			$map = array("link_id"=>array("in", $chkt));
			$links = M("links")->where($map)->getField("link_name", true);
			if(M("links")->where($map)->delete()){
				$this->watchdog("删除", "删除友情链接《".implode("》,《", $links)."》。");
				$this->success("删除友情链接《".implode("》,《", $links)."》成功！");
			}else{
				$this->error("删除失败！");
			}
		}
	}
	
	/**
	 * 友情链接
	 */
	public function advs(){
		$adv = M("advs");
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['adv_name']  = array('like', "%{$words}%");
				$where['adv_title']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $adv->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//$order = "link_order";
		$advs = $adv->where($map)->limit($limit)->select();
		//换色
		foreach($advs as &$v){
			$v['adv_code'] = htmlspecialchars($v['adv_code']);
			if(!empty($param['words'])){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/ig", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("advs", $advs);
		$this->display();
	}
	/**
	 * 添加友情链接
	 */
	public function advs_add($action=""){
		if($action=="add"){
			if(!per_check("advs_edit")){
				$this->error("无此权限！");
			}
			$data = M("advs")->create();
			if(M("advs")->add($data)){
				$this->watchdog("新增", "添加广告 {$data['adv_name']}:{$data['adv_desc']}");
				$this->success("添加成功！", __URL__."/advs");
			}else{
				$this->error("添加失败！");
			}
		}else{
			if(!per_check("advs_edit")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加广告</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="adv_area">广告区域名</label>
						<div class="controls">
							 <input type="text" id="adv_area" name="adv_area" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="adv_desc">广告说明</label>
						<div class="controls">
						  	<textarea name="adv_desc" id="adv_desc" style="width:320px;height:100px;"></textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="adv_code">广告代码</label>
						<div class="controls">
						  	<textarea name="adv_code" id="adv_code" style="width:320px;height:180px;"></textarea>
							<br />
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
	 * 修改友情链接
	 * @param string $man_id
	 */
	public function advs_edit($action = ""){
		if($action=="edit"){
			if(!per_check("advs_edit")){
				$this->error("无此权限！");
			}
			else{
				$data = M("advs")->create();
				if(M("advs")->save($data)){
					$this->watchdog("编辑", "修改广告 {$data['adv_name']}:{$data['adv_desc']}");
					$this->success("保存成功！", __URL__."/advs");
				}else{
					$this->error("保存失败！");
				}
			}
		}else{
			if(!per_check("advs_edit")){
				echo response_msg("无此权限!", "error", true);
				exit;
			}
			if(!isset($_REQUEST['id'])){
				echo response_msg("参数错误！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="adv_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改广告信息</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="adv_area">广告区域名称</label>
						<div class="controls">
							 <input type="text" id="adv_area" name="adv_area" value="%area%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="adv_desc">广告说明</label>
						<div class="controls">
						  	<textarea name="adv_desc" id="adv_desc" style="width:320px;height:100px;">%desc%</textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="adv_code">广告代码</label>
						<div class="controls">
						  	<textarea name="adv_code" id="adv_code" style="width:320px;height:180px;">%code%</textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$info = M("advs")->where("adv_id={$_REQUEST['id']}")->find();
			if(empty($info)){
				echo response_msg("参数错误!", "error", true);
				exit;
			}
			echo str_replace(array("%id%", "%area%","%desc%", "%code%", "%url%"), array($info['adv_id'], $info['adv_area'], $info['adv_desc'], $info['adv_code'], __ACTION__), $responseHTML);
		}
	}
	
	/**
	 * 预览广告
	 */
	public function advs_view($id=""){
		if($id){
			$code = M("advs")->where("adv_id={$id}")->getField("adv_code");
			if($code){
				exit($code);
			}else{
				$this->closeWin = true;
				$this->error("参数错误！");
			}
		}else{
			$this->closeWin = true;
			$this->error("参数错误！");
		}
	}
	
	
	/**
	 * 删除广告
	 * @param string $chkt
	 */
	public function advs_delete($chkt=""){
		if(!per_check("advs_edit")){
			$this->error("无此权限！");
		}else{
			$map = array("adv_id"=>array("in", $chkt));
			$advs = M("advs")->where($map)->select();
			$detail = "删除广告：";
			foreach ($advs as $v){
				$detail .= "<br />".$v['adv_area']."--".$v['adv_desc'];
			}
			if(M("advs")->where($map)->delete()){
				$this->watchdog("删除", $detail);
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}
		}
	}
	
	/**
	 * 更新缓存
	 */
	public function advs_update(){
		if(!per_check("advs_edit")){
			$this->error("无此权限！");
		}
		if(D("Advs")->updateCache()){
			$this->success("更新成功！");
		}else{
			$this->error("更新失败！");
		}
	}

	/**
	 * 首页区块
	 */
	public function blocks($group=""){
		$block = M("block");
		$map = empty($group) ? array() : array("bl_group"=>$group);
		$total = $block->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "bl_order";
		$blocks = $block->where($map)->limit($limit)->select();
		$this->assign("blocks", blocks);
		$this->display();
	}
	/**
	 * 添加区块
	 */
	public function blockAdd($action=""){
		if($action=="add"){
			if(!per_check("block_edit")){
				$this->error("无此权限！");
			}
			$data = M("block")->create();
			if(M("block")->add($data)){
				$this->watchdog("新增", "添加区块".$data['bl_group']."的".$data['block_title']."元素。");
				$this->success("添加成功！", __URL__."/blocks/group/{$data['bl_group']}");
			}else{
				$this->error("添加失败！");
			}
		}else{
			$this->assign("group", $_REQUEST['group']);
			$this->display();
		}
	}
	
	/**
	 * 修改友情链接
	 * @param string $man_id
	 */
	public function blockEdit($action = ""){
		if(!per_check("block_edit")){
			$this->error("无此权限！");
		}
		if($action=="edit"){
			$data = M("block")->create();
			if(M("block")->save($data)){
				$this->watchdog("编辑", "修改区块".$data['bl_group']."的".$data['block_title']."元素。");
				$this->success("保存成功！");
			}else{
				$this->error("保存失败！");
			}
		}else{
			$info = M("block")->where("bl_id='{$_REQUEST['id']}'")->find();
			if(empty($info)){
				$this->error("参数错误!");
			}else{
				$this->assign("info", $info);
				$this->display();
			}
			
		}
	}
	
	/**
	 * 更新缓存
	 */
	public function blockUpdate(){
		
	}
	
	/**
	 * 删除区块
	 * @param string $chkt
	 */
	public function blockDel($id=""){
		if(!per_check("block_edit")){
			$this->error("无此权限！");
		}else{
			$map = array("bl_id"=>array("in", $chkt));
			$blocks = M("block")->where($map)->select();
			foreach ($advs as $v){
				$detail .= "<br />删除区块".$v['bl_group']."的".$v['block_title']."元素。";
			}
			if(M("block")->where($map)->delete()){
				$this->watchdog("删除", $detail);
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}
		}
	}
	
}