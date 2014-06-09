<?php
class MemberAction extends CommonAction{
	/**
	 * 用户中心
	 */
	public function index(){
		
	}
	
	/**
	 * 检测用户登录状态
	 */
	public static function checkMember(){
		if(empty($_SESSION['member'])){
			redirect(__URL__."/login");exit;
		}
	}
	
	/**
	 * 登录页
	 */
	public function login(){
		
	}
	/**
	 * 验证用户
	 */
	public function checkLogin(){
		
	}
	
	/**
	 * 注册页
	 */
	public function register(){
		
	}
	/**
	 * 保存注册信息
	 */
	public function reg(){
		
	}

	
	/**
	 * 发送验证邮件
	 */
	public function sendVerifyMail($member, $mail, $verifyCode){
		$subject = "";
		$body = "";
		return think_send_mail($mail, $member, $subject, $body);
	}
	
	/**
	 * 验证邮箱有效性,绑定邮箱
	 */
	public function verifyMail($member, $verifyCode){
		
	}
	
	/**
	 * 发送短信验证码
	 */
	public function sendMessage($memeber, $tel, $verifyCode){
		
	}
	/**
	 * 绑定手机
	 */
	public function verifyTel($memeber, $verifyCode){
		
	}
	
	/**
	 * 找回密码
	 */
	public function retrieve($step="1"){
		
	}
	
	/**
	 * 修改密码
	 */
	public function memberSafe(){
		
	}
	/**
	 * 修改资料
	 */
	public function memberInfo(){
		
	}
	
	/**
	 * 系统通知
	 */
	public function sysNotice(){
		
	}
	
	/**
	 * 收藏项目
	 */
	public function proCollection(){
		
	}
	
	/**
	 * 充值消费记录
	 */
	public function dueRecord(){
		
	}
	
}