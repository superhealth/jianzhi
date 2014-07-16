<?php
/**
 * 公共模块
 * @author Carl
 *
 */
class CommonAction extends EmptyAction{
	/**
	 * 初始化方法
	 */
	public function _initialize(){
		
	}
	
	/**
	 * 检测用户登录状态
	 */
	public function checkMember(){
		if(empty($_SESSION['member'])){
			$this->error("请先登录！", __GROUP__."/Member/login");exit;
		}
	}
	
	/**
	 * 验证码
	 */
	public function getAuthcode(){
		import("ORG.Util.Image");
		Image::buildImageVerify($length=4, $mode=1, $type='png', $width=48, $height=22, $verifyName='authcode');
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
        $this->display("Common:success");
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
		$this->display("Common:error");
		exit ;
	}
}