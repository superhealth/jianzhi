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
		
		$this->memberInit();
	}
	/**
	 * 初始化会员信息
	 */
	function memberInit(){
		if(isset($_SESSION['member'])){
			$memberInfo = "";
			$this->assign("memberInfo", $memberInfo);
		}
	}
	
	
	public function getAuthcode(){
		import("ORG.Util.Image");
		Image::buildImageVerify($length=4, $mode=1, $type='png', $width=48, $height=22, $verifyName='authcode');
	}
}