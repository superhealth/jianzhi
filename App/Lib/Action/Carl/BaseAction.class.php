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
		$_SESSION['user'] = "carl";
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
	 * 操作成功
	 */
	public function success($message,$jumpUrl='',$wait=1){
		$this->assign('waitSecond',$wait);
        if(!empty($jumpUrl)) $this->assign('jumpUrl',$jumpUrl);
        $this->assign('msgTitle',L('_OPERATION_SUCCESS_'));
        if($this->get('closeWin'))    $this->assign('jumpUrl','javascript:window.close();');
        C('HTML_CACHE_ON',false);
        $this->assign('message',$message);
        if(!isset($this->jumpUrl)) $this->assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
        $this->display("Base:success");
    }
	
	/**
	 * 操作失败
	 * 
	 */
	public function error($message,$jumpUrl='',$wait=3){
		$this->assign('waitSecond',$wait);
		if(!empty($jumpUrl)) $this->assign('jumpUrl',$jumpUrl);
		$this->assign('msgTitle',L('_OPERATION_FAIL_'));
		if($this->get('closeWin'))    $this->assign('jumpUrl','javascript:window.close();');
		C('HTML_CACHE_ON',false);
		$this->assign('error',$message);
		if(!isset($this->jumpUrl)) $this->assign('jumpUrl',"javascript:history.back(-1);");
		$this->display("Base:error");
		exit ;
	}	
}


?>