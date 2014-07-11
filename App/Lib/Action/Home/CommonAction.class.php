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
}