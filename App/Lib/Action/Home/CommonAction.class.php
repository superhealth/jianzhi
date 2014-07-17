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
		if(!empty($_SESSION['member'])){
			$notice = D("Notice")->noRead($_SESSION['member']);
			$this->assign("notice", $notice);
			$type = M("member")->where("mem_id='{$_SESSION['member']}'")->getField("mem_type");
			if($type==1){
				$status = M("membercompany")->where("mc_mid='{$_SESSION['member']}'")->getField("mc_status");
			}else{
				$status = M("memberperson")->where("mp_mid='{$_SESSION['member']}'")->getField("mp_status");
			}
			$this->assign("status", $status);
		}
	}
	
	/**
	 * 检测用户登录状态
	 */
	public function checkMember(){
		if(empty($_SESSION['member'])){
			$this->error("请先登录！", __GROUP__."/Member/login/flag/true", 1);exit;
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
	public function success($message,$jumpUrl='',$wait=3){
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
	public function error($message,$jumpUrl='',$wait=5){
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