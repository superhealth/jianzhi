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
	public function sendVerifyMail($member){
		$email = M("member")->where("mem_id='{$member}'")->getField("mem_email");
		if(empty($email)){
			$this->error("不存在的用户或未绑定邮箱！");
		}
		$verify = array("code"=>randomStr(8, 4), "expire"=>time());
		$verify = json_encode_nonull($verify);
		M("member")->where("mem_id='{$member}'")->setField("mem_verifycode", $verify);
		$subject = "[招投网]验证您的电子邮箱地址";
		$body = ":)";
		if(think_send_mail($email, $member, $subject, $body)){
			$this->success("邮件发送成功！");
		}else{
			$this->error("邮件发送失败！");
		}
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
	public function safty(){
		
	}
	/**
	 * 修改资料
	 */
	public function myInfo(){
		
	}
	
	/**
	 * 查看会员资料
	 */
	public function memberInfo($id=""){
		
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