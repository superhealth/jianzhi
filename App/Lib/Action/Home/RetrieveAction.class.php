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
	
	/**
	 * 找回密码step2
	 * 接收用户名$user, 发送安全操作码。
	 */
	public function step2(){
		$user = addslashes($_REQUEST['user']);
		if(empty($user)){
			if($_COOKIE['retrieve']){
				$user = addslashes($_COOKIE['retrieve']);
			}else{
				$this->error('请填写您注册的用户名以帮助找回密码！', __URL__."/step1");
			}
		}else{
			$send = verifyCode($user, $subject="[订单网] 找回密码申诉");
			if($send===true){
				setcookie('retrieve', $user, $_SERVER['REQUEST_TIME']+3600);
			}elseif($send===false){
				$this->error("验证码邮件发送失败，请稍后再试！", __URL__."/step1");
			}else{
				$this->error($send, __URL__."/step1");
			}
		}
		$info = M('member')->where('mem_id="'.$user.'"')->find();
		$info['email'] = emailToHide($info['mem_email']);
		$this->assign('info', $info);
		$this->display();
	}
	
	/**
	 * 找回密码step3
	 * 验证安全吗是否正确， 显示修改密码框
	 * 
	 */
	public function step3(){
		if(empty($_POST['user'])){
			$this->error('请填写您注册的用户名以帮助找回密码！', __URL__."/step1");
		}else{
			$user = addslashes($_POST['user']);
			$code = addslashes($_POST['code']);
			$check = D('Member')->checkVerifyCode($user, $code);
			if($check!==true){
				$this->error('安全码输入错误！', __URL__.'/step2');
			}else{
				//验证通过
				setcookie('retrieve', '', $_SERVER['REQUEST_TIME']-3600);
				$_SESSION['retrieve'] = $user;
				$this->display();
			}
		}
	}
	
	/**
	 * 找回密码 ed
	 * 提示修改成功 or 失败
	 */
	public function steped(){
		if(!empty($_SESSION['retrieve'])){
			if(M("member")->where('mem_id="'.$_SESSION['retrieve'].'"')->setField('mem_password', md5($_POST['newpass']))){
				unset($_SESSION['retrieve']);
				$this->display();
			}else{
				$this->error('修改密码失败！请重复以上步骤或联系网站工作人员，谢谢！', __URL__.'/step1');
			}
		}else{
			$this->_empty();
		}
	}
	
	/**
	 * 验证安全码是否正确
	 * @param string $user
	 * @param string $code
	 */
	public function checkCode($user="", $code=""){
		$user = addslashes($user);
		$check = D('Member')->checkVerifyCode($user, $code);
		if($check!==true){
			exit($check);
		}else{
			exit('success');
		}
	}
	
	
	/**
	 * 再次发送安全码
	 */
	public function reCode(){
		if($_SERVER['REQUEST_TIME']-$_SESSION['emailSendTime']<180){
			exit('您的操作太过频繁，请稍后再试！');
		}
		$send = verifyCode(addslashes($_REQUEST['user']), $subject="[订单网] 找回密码操作安全码");
		if($send===true){
			$_SESSION['emailSendTime'] = $_SERVER['REQUEST_TIME'];
			exit('邮件已发送！');
		}elseif($send===false){
			exit('安全码邮件发送失败，请稍后再试！');
		}else{
			exit($send);
		}
	}
	

	
}