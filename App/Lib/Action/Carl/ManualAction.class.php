<?php
class ManualAction extends BaseAction{
	/**
	 * 手册下载列表
	 */
	public function index(){
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['man_name']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = M("manual")->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 16, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "man_order";
		$manulas = M("manual")->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($manulas as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("manuals", $manulas);
		$this->display();
	}
	/**
	 * 添加
	 */
	public function manual_add(){
		if(!per_check("manual_manger")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="add" />	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>上传手册</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="man_name">手册名称</label>
					<div class="controls">
						 <input type="text" id="man_name" name="man_name"/>
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="man_order">显示次序</label>
					<div class="controls">
					  	<input type="text" id="man_order" name="man_order"/>
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="man_file">上传手册</label>
					<div class="controls">
					  	<input type="file" id="man_file" name="man_file"/>
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="manual_commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
		$url = __URL__."/manual_save";
		echo str_replace("%url%", $url, $responseHTML);
	}
	/**
	 * 保存
	 */
	public function manual_save(){
		if(!per_check("manual_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$data = M("manual")->create();
			$data['man_time'] = time();
			if(!is_numeric($data["man_order"])){
				$lastestId = M("manual")->order("man_id DESC")->limit(1)->getField("man_id");
				$data['man_order'] = $lastestId+1;
			}
			$info = $this->uploadImg(false);
			if($info[0]){
				$data['man_savename'] = $info[1][0]['savename'];
				if(M("manual")->add($data)){
					$this->watchdog("新增", "成功上传《{$data['man_name']}》！");
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}else{
				$msg = response_msg("UPLOAD_FAILED");
			}
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	/**
	 * 查看
	 * @param string $man_id
	 */
	public function manual_edit($man_id=""){
		if(!per_check("manual_manger")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="man_id" value="%man_id%" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>上传手册</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="man_name">手册名称</label>
					<div class="controls">
						 <input type="text" id="man_name" name="man_name" value="%man_name%" />
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="man_order">显示次序</label>
					<div class="controls">
					  	<input type="text" id="man_order" name="man_order" value="%man_order%" />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="man_file">更换手册</label>
					<div class="controls">
					  	<input type="file" class="input-file uniform_on" id="man_file" name="man_file"/>
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="manual_commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
		$manual_info = M("manual")->where("man_id={$man_id}")->find();
		if(empty($manual_info)){
			echo response_msg("参数错误！", "error", true);
			exit;
		}
		$url = __URL__."/manual_modify";
		echo str_replace(array("%man_id%", "%man_name%", "%man_order%","%url%"), array($manual_info['man_id'], $manual_info['man_name'], $manual_info['man_order'], $url), $responseHTML);
		
	}
	/**
	 * 保存修改
	 */
	public function manual_modify(){
		if(!per_check("manual_manger")){
			$msg = response_msg("ACCESS_DENIED");
			exit;
		}else{
			$data = M("manual")->create();
			if(!is_numeric($data['man_order'])){
				unset($data['man_order']);
			}
			$upload_flag = false;
			foreach($_FILES as $v){
				if($v['name']!=""){
					$upload_flag = true;break;
				}
			}
			if($upload_flag){
				$info = $this->uploadImg(false);
				if($info[0]){
					$data['man_savename'] = $info[1][0]['savename'];
					$oldFile = M("manual")->where("man_id={$data['man_id']}")->getField("man_savename");
				}else{
					$msg = response_msg("UPLOAD_FAILED");
					redirect(__URL__."/index/msg/{$msg}");exit;
				}
			}
			if(M("manual")->save($data)){
				$this->watchdog("编辑", "修改用户手册《{$data['man_name']}》.");
				//删除原文件
				if($oldFile){
					$this->delOldImg($oldFile);
				}
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	/**
	 * 删除
	 * @param string $chkt
	 */
	public function manual_delete($chkt=""){
		if(!per_check("manual_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			if(!is_array($chkt)){
				$chkt = array($chkt);	
			}
			$map = array("man_id"=>array("in", $chkt));
			$manuals = M("manual")->where($map)->select();
			if(M("manual")->where($map)->delete()){
				foreach($manuals as $v){
					$this->delOldImg($v['man_savename']);
					$names[] = $v['man_name'];
				}
				$this->watchdog("删除", "删除手册《".implode("》,《", $names)."》");
				$msg = response_msg("OPERATION_SUCCESS", "success");
				
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	/**
	 * 下载测试
	 * @param string $man_id
	 */
	public function manual_download($man_id=""){
		if(!per_check("manual_manger")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/index/msg/{$msg}");
			exit;
		}
		$savename = M("manual")->where("man_id={$man_id}")->getField("man_savename");
		if($savename){
			$downresult = $this->download($savename);
			if(true !== $downresult){
				$msg = response_msg("OPERATION_FAILED");
				redirect(__URL__."/index/msg/{$msg}");
			}
		}
	}
	
	/**
	 * 壁纸管理
	 */
	public function desktop(){
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['de_title']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = M("desktop")->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 16, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "de_order";
		$desktops = M("desktop")->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($desktops as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("desktops", $desktops);
		$this->display();
	}
	/**
	 * 添加
	 */
	public function desktop_add(){
		if(!per_check("desktop_manger")){
			echo response_msg("Access_Denied!", "error", true);
			exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="add" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>上传壁纸</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="de_title">壁纸名称</label>
					<div class="controls">
						 <input type="text" id="de_title" name="de_title"/>
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="de_order">显示次序</label>
					<div class="controls">
					  	<input type="text" id="de_order" name="de_order"/>
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="de_file">上传手册</label>
					<div class="controls">
					  	<input type="file" id="de_file" name="de_file"/>
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="desktop_commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
		$url = __URL__."/desktop_save";
		echo str_replace("%url%", $url, $responseHTML);
	}
	/**
	 * 保存
	 */
	public function desktop_save(){
		if(!per_check("desktop_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$data = M("desktop")->create();
			$data['de_time'] = time();
			if(!is_numeric($data["de_order"])){
				$lastestId = M("desktop")->order("de_id DESC")->limit(1)->getField("de_id");
				$data['de_order'] = $lastestId+1;
			}
			$info = $this->uploadDesktop();
			if($info[0]){
				$data['de_src'] = $info[1][0]['savename'];
				if(M("desktop")->add($data)){
					$this->watchdog("新增", "成功上传壁纸《{$data['de_title']}》！");
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED".M("desktop")->getError());
				}
			}else{
				$msg = response_msg("UPLOAD_FAILED");
			}
		}
		redirect(__URL__."/desktop/msg/{$msg}");
	}
	/**
	 * 查看
	 * @param string $man_id
	 */
	public function desktop_edit($de_id=""){
		if(!per_check("desktop_manger")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="de_id" value="%de_id%" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>修改壁纸</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="de_title">壁纸名称</label>
					<div class="controls">
						 <input type="text" id="de_title" name="de_title" value="%de_title%" />
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="de_order">显示次序</label>
					<div class="controls">
					  	<input type="text" id="de_order" name="de_order" value="%de_order%" />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="de_file">更换壁纸</label>
					<div class="controls">
					  	<input type="file" class="input-file uniform_on" id="de_file" name="de_file"/>
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="desktop_commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
		$desktop_info = M("desktop")->where("de_id={$de_id}")->find();
		if(empty($desktop_info)){
			echo response_msg("Invalid Arguments!", "error", true);
			exit;
		}
		$url = __URL__."/desktop_modify";
		echo str_replace(array("%de_id%", "%de_title%", "%de_order%","%url%"), array($desktop_info['de_id'], $desktop_info['de_title'], $desktop_info['de_order'], $url), $responseHTML);
	
	}
	/**
	 * 保存修改
	 */
	public function desktop_modify(){
		if(!per_check("desktop_manger")){
			$msg = response_msg("Access Denied!");
		}else{
			$data = M("desktop")->create();
			if(!is_numeric($data['de_order'])){
				unset($data['de_order']);
			}
			$upload_flag = false;
			foreach($_FILES as $v){
				if($v['name']!=""){
					$upload_flag = true;break;
				}
			}
			if($upload_flag){
				$info = $this->uploadDesktop();
				if($info[0]){
					$data['de_src'] = $info[1][0]['savename'];
					$oldFile = M("desktop")->where("de_id={$data['de_id']}")->getField("de_savename");
				}else{
					$msg = response_msg("UPLOAD_FAILED");
					redirect(__URL__."/desktop/msg/{$msg}");exit;
				}
			}
			if(M("desktop")->save($data)){
				$this->watchdog("编辑", "修改用户手册《{$data['de_name']}》.");
				//删除原文件
				if($oldFile){
					$this->delOldImg("mi_".$oldFile);
					$this->delOldImg("1280_".$oldFile);
					$this->delOldImg("1366_".$oldFile);
					$this->delOldImg("1440_".$oldFile);
					$this->delOldImg("1920_".$oldFile);
					
				}
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/desktop/msg/{$msg}");
	}
	/**
	 * 删除
	 * @param string $chkt
	 */
	public function desktop_delete($chkt=""){
		if(!per_check("desktop_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			if(!is_array($chkt)){
				$chkt = array($chkt);
			}
			$map = array("de_id"=>array("in", $chkt));
			$manuals = M("desktop")->where($map)->select();
			if(M("desktop")->where($map)->delete()){
				foreach($manuals as $v){
					$this->delOldImg("mi_".$v['de_src']);
					$this->delOldImg("1920_".$v['de_src']);
					$this->delOldImg("1440_".$v['de_src']);
					$this->delOldImg("1366_".$v['de_src']);
					$this->delOldImg("1280_".$v['de_src']);
					$names[] = $v['de_title'];
				}
				$this->watchdog("删除", "删除手册《".implode("》,《", $names)."》");
				$msg = response_msg("OPERATION_SUCCESS", "success");
					
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/desktop/msg/{$msg}");
	}
	
	
	/**
	 * 
	 * @return string
	 */
	protected function uploadDesktop(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->thumb = true;							//是否生成缩略图
		$upload->thumbFlag = false;					//true为等比缩放输出，false按照设定大小输出
		$upload->thumbMaxWidth = '228,1280,1366,1440,1920';			//缩略图最大宽度
		$upload->thumbMaxHeight = '171,800,768,900,1080';			//缩略图最大高度
		$upload->thumbPrefix = 'mi_,1280_,1366_,1440_,1920_';					//缩略图前缀
		$upload->uploadReplace = false;
		$upload->maxSize  = 3145728*1024 ;				// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'pdf', 'txt');		// 设置附件上传类型
		$upload->savePath = './uploads/';	// 设置附件上传目录
		if(!$upload->upload()) {
			$info[] = false;
			$info[] = $upload->getErrorMsg();	// 上传错误提示错误信息
		}else{
			$info[] = true;
			$info[] = $upload->getUploadFileInfo();	// 上传成功 获取上传文件信息
		}
		return $info;
	}

}