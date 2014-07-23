<?php
/**
 * 找回密码模块
 * @author dapianzi
 *
 */
class RetrieveAction extends CommonAction{
	public function index(){
		redirect(__URL__."/step1");
	}
	
	/**
	 * 找回密码 step1
	 */
	public function step1(){
		$this->display();
	}
	
	public function step2(){
		if(empty($_REQUEST['user'])){
			$this->error('请填写您注册的用户名以帮助找回密码！', __URL__."/step1");
		}else{
			$user = addslashes($_REQUEST['user']);
			$send = verifyCode($user, $subject="[订单网] 找回密码申诉");
			if($send===true){
				$info = M('member')->where('mem_id="'.$user.'"')->find();
				$info['email'] = emailToHide($info['mem_email']);
				$this->assign('info', $info);
				$this->display();
			}elseif($send===false){
				$this->error("验证码邮件发送失败，请稍后再试！", __URL__."/step1");
			}else{
				$this->error($send, __URL__."/step1");
			}
		}
	}
	
	public function step3(){
		if(empty($_REQUEST['user'])){
			$this->error('请填写您注册的用户名以帮助找回密码！', __URL__."/step1");
		}else{
		
		}
	}
	
	public function steped(){
		
	}
	
	
	public function checkCode($user="", $code=""){
		$user = addslashes($user);
		$check = D('Member')->checkVerifyCode($user, $code);
		if($check!==true){
			exit($check);
		}else{
			exit('success');
		}
	}
	
	public function reCode(){
		if(empty($_REQUEST['user'])){
			exit('请填写您注册的用户名以帮助找回密码！');
		}else{
			$send = verifyCode($_REQUEST['user'], $subject="[订单网] 找回密码申诉");
			if($send===true){
				$this->display();
			}elseif($send===false){
				$this->error("验证码邮件发送失败，请稍后再试！", __URL__."/step1");
			}else{
				$this->error($send, __URL__."/step1");
			}
		}
	}
	

	
}