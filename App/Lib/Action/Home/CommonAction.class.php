<?php
/**
 * 公共模块
 * @author dapianzi
 *
 */
class CommonAction extends EmptyAction{
	/**
	 * 初始化方法
	 */
	public function _initialize(){
		if(!empty($_SESSION['member'])){
			$notice = D("Notice")->noRead($_SESSION['member']);
			$this->assign("memberNotice", $notice);
			$this->assign("memberStatus", D('Member')->getMemberStatus($_SESSION['member']));
		}
		$this->assign('headerSorts', D('Sort')->getSorts()); 
	}
	
	public function leftInit(){
		if(!empty($_SESSION['member'])){
			$noticeCount = D('Notice')->noticeCount($_SESSION['member']);
			$this->assign('noticeCount', $noticeCount);
		}
	}
	
	/**
	 * 检测用户登录状态
	 */
	public function checkMember(){
		if(empty($_SESSION['member'])){
			$this->assign("url",'1');
			$this->display("Member:login");exit;
		}
	}
	
	/**
	 * 验证码
	 */
	public function getAuthcode(){
		import("ORG.Util.Image");
		/* 获取验证码 */
		Image::buildImageVerify($length=4, $mode=5, $type='png', $width=48, $height=22, $verifyName='authcode');
		
	}
	/**
	 * 检查验证码
	 */
	public function checkAuthcode($authcode=""){
		if($_SESSION['authcode'] == md5(strtolower($authcode))){
			exit('ok');
		}else{
			exit('fail');
		}
	}
	/**
	 * 操作成功
	 */
	public function success($message,$jumpUrl='',$wait=2){
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
	public function error($message,$jumpUrl='',$wait=4){
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