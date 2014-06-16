<?php
/**
 * 友情提示模块
 * @author Carl
 *
 */
class TipsAction extends BaseAction{
	/**
	 * 浏览
	 */
	public function index(){
		$param = array();
		$map = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['tips_name'] = array("like", "%{$_REQUEST['words']}%");
				$where['tips_content'] = array("like", "%{$_REQUEST['words']}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
				$param['name'] = $_REQUEST['name'];
			}
		}
		// total
		$total = M("tips")->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$tips = M("tips")->where($map)->limit($limit)->select();
		foreach($sysconf as &$v){
			foreach($v as &$val){
				$val = preg_replace("/(".$param['words'].")/ig", "<span class='red'>\\1</span>", $val);
			}
		}
		$this->assign("tips", $tips);
		$this->display();
	}
	
	/**
	 * 添加
	 */
	public function add(){
		if(!per_check("tips_edit")){
			echo response_msg("无此权限！", "error", true);exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal"><fieldset>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加友情提示</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="tips_key">友情提示标识</label>
						<div class="controls">
							 <input type="text" id="tips_key" name="tips_key">
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tips_name">友情提示描述</label>
						<div class="controls">
						  	<input type="text" id="tips_name" name="tips_name">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tips_content">友情提示内容</label>
						<div class="controls">
						  	<testarea id="tips_content" name="tips_content"></textarea>
						  	<br /><span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
		echo str_replace("%url%", __URL__."/addTo", $responseHTML );
	}
	
	/**
	 * 添加到数据库
	 */
	public function addTo(){
		if(!per_check("tips_edit")){
			$this->error("无此权限！");
		}
		$data = M("tips")->create();
		if(M("tips")->add($data)){
			$detail = "添加友情提示 [%key%]=>%name%";
			$this->watchdog("新增", str_replace(array("%key%", "%name%"), array($data['tips_key'], $data['tips_name']), $detail));
			$this->success("添加成功！", __URL__."/index");
		}else{
			$this->error("添加失败！");
		}
	}
	
	/**
	 * 修改
	 */
	public function edit($id=""){
		if(!per_check("tips_edit")){
			echo response_msg("无此权限！", "error", true);exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="tips_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加友情提示</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="tips_key">友情提示标识</label>
						<div class="controls">
							 <input type="text" id="tips_key" name="tips_key" value="%key%">
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tips_name">友情提示描述</label>
						<div class="controls">
						  	<input type="text" id="tips_name" name="tips_name" value="%name%">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tips_content">友情提示内容</label>
						<div class="controls">
						  	<testarea id="tips_content" name="tips_content">%content%</textarea>
						  	<br /><span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
		$info = M("tips")->where("tops_id={$id}")->find();
		if($info){
			echo str_replace(array("%id%", "%key%", "%name%", "%content%", "%url%"),array($info['tips_id'], $info['tips_key'], $info['tips_name'], $info['tips_content'], __URL__."/save"), $responseHTML );
		}else{
			echo response_msg("参数错误！", "error", true);exit;
		}
	}
	
	/**
	 * 保存修改
	 */
	public function save(){
		if(!per_check("tips_edit")){
			$this->error("无此权限！");
		}else{
			$data = M("tips")->create();
			if(M("tips")->save($data)){
				$this->watchdog("编辑", "修改友情提示[{$data['tips_key']}]=>{$data['tips_name']}");
				$this->success("修改成功！", __URL__."/index");
			}else{
				$this->error("修改失败！");
			}
		}
	}
	
	/**
	 * 删除
	 */
	public function delete($id=""){
		if(!per_check("tips_edit")){
			$this->error("无此权限！");
		}
		$tips = M("tips")->where("tips_id={$id}")->select();
		if(M("tips")->where("tips_id={$id}")->delete()){
			$detail = "";
		}
		
	}
	
	/**
	 * 更新缓存文件
	 */
	public function saveCache(){
		if(!per_check("tips_edit")){
			$this->error("无此权限！");
		}else{
			@chmod(SYSCONF_DIR, 0777);
			$f = fopen(SYSCONF_DIR."/tips_inc.php", "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！');</script>");
			$sysconfig = M("tips")->select();
			$str = "<?php \nreturn array( \n";
			foreach($sysconfig as $v){
				$str .= "\"{$v['tips_key']}\" => \"{$v['tips_content']}\", // {$v['tips_name']} \n";
			}
			$str .= "); \n?>";
			$result = fwrite($f,$str);
			fclose($f);
			if($result){
				$this->success("缓存写入成功！");
			}else{
				$this->error("缓存写入失败！请检查./cache目录是否可写。");
			}
		}
	}
	
}