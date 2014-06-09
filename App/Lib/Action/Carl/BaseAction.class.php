<?php
class BaseAction extends Action{
	protected $result_msg = array(
		'ACCESS_DENIED'		=>"无此权限！",
		'INVALID_ARGUMENT' 	=> "参数错误！",
		'OPERATION_SUCCESS'=> "操作成功！",
		'OPERATION_FAILED' 	=> "操作失败！",
		'UPLOAD_FAILED'		=> "上传失败！",
		'EMPTY_SUBJECT'		=> "邮件主题为空！",
		'EMPTY_CONTENT'		=> "邮件内容为空！",
		'FILE_NOT_EXIST'		=> "文件不存在！",
		'ADD_EXIST'				=> "重复操作！",
		'MYSQL_CONNECT_FAILED'	=> "数据库连接失败！",
		''
	);
	protected function _initialize(){
		if(is_null($_SESSION['user'])){
			send_http_status("404");
			redirect(__APP__."/Empty/404.html");
		}
		if($_GET['msg']){
			$msg = explode("-", $_GET['msg']);
			$msg[1] = $this->result_msg[$msg[1]];
			$this->assign("msg", $msg);
		}
	}
	
	/* 写入日志 */
	public function watchdog($action="", $info=""){
		$log = array(
			'log_time' 	=> time(),
			'log_user' 	=> $_SESSION['user'],
			'log_ip'		=> $_SERVER['REMOTE_ADDR'],
			'log_action'	=> $action,
			'log_detail'	=> $info
		);
		M("log")->add($log);
	}
	
	/**
	 * 图片上传
	 * @return string
	 */
	
	protected function uploadImg($imgOnly=true){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->thumb = true;							//是否生成缩略图
		$upload->thumbMaxWidth = '180';			//缩略图最大宽度
		$upload->thumbMaxHeight = '40';			//缩略图最大高度
		$upload->thumbPrefix = 'mi_';					//缩略图前缀
		$upload->thumbRemoveOrigin = false;			//
		$upload->uploadReplace = true;
		$upload->maxSize  = 3145728*1024 ;				// 设置附件上传大小
		if($imgOnly){
			$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');
		}else{
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'pdf', 'txt');		// 设置附件上传类型
		}
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
	
	/**
	 * 
	 * 删除图片
	 */
	protected function delOldImg($img){
		if($img!="default.jpg"){
			$path = $_SERVER['DOCUMENT_ROOT'].__ROOT__."/uploads/";
			unlink($path.$img);
		}
	}
	/**
	 * 文件下载类
	 * @param 文件名 $file
	 * @return boolean
	 */
	protected function download($file){
		import("ORG.Net.Http");
		$down = new Http();
		$filename = $_SERVER['DOCUMENT_ROOT'].__ROOT__."/uploads/".$file;
		if(!$down->download($filename)) {
			return $down->geterrormsg();
		}
		return true;
	}

	
}