<?php
class LoginAction extends Action{
	/* 后台登陆 */
	public function index(){
		$this->display();
	}
	
	/* 验证 */
	public function checkLogin($user="", $pass="", $authcode=NULL){
		$response = array(
				'code'=>0, 
				'msg'=>""
		);
		//是否开启验证码
		$authcode_check = true;
		//$authcode_check = M("sysconf")->where("cfg_key='authcode_check'")->getField("cfg_value");
		if($authcode_check && md5($authcode) != $_SESSION['verify']){
			$response['code'] = 1;
			$response['msg'] = "验证码不匹配";
		}else{
			if(!empty($user)){
				$userModel = M("admin")->where("name='$user'")->find();
				if(md5($pass) == $userModel['pass']){
					$_SESSION['user'] = $userModel['name'];
					$response['msg'] = "success";
					BaseAction::watchdog("登录");
					M("user")->where("name='$user'")->setField("login", time());
				}else{
					$response['code'] = 2;
					$response['msg'] = "用户名或密码错误";
				}
			}else{
				$response['code'] = 3;
				$response['msg'] = "请输入用户名";
			}
		}
		echo json_encode_nonull($response);
	}
	
	/* 获取验证码 */
	public function authcode(){
		import("ORG.Util.Image");
		$img = new Image();
		$img->buildImageVerify($length=4, $mode=1, $type='png', $width=48, $height=22, $verifyName='verify');
	}
	
}