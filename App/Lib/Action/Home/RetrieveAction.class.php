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
	
	public function step3(){
		if(){
		
		}
		
	}
		
	public function checkCode($user="", $code=""){
		$user = addslashes($user);
		$verify = M("member")->where("mem_id='{$user}'")->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = explode("-", $verify);
			if($verifyInfo[1] > time()-7*24*3600){
				if($verifyCode == $verifyInfo[0]){
					//验证通过
					exit('success');
				}else{
					exit('fail');
				}
			}else{
				exit('expired');
			}
		}else{
			exit('用户信息错误！请确认用户名是否正确，返回重新验证。');
		}
		
	}
	
	public function reCode(){
		
	}
	
}