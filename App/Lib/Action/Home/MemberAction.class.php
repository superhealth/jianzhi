<?php
class MemberAction extends CommonAction{
	/**
	 * 用户中心
	 */
	public function index(){
		$this->checkMember();
		$this->memberInit();
		//$this->assign("member", $GLOBALS['member']);
		
		dump($GLOBALS['member']);
		echo '<a href="'.__URL__.'/logout">退出</a>';
	}
	
	/**
	 * 登录页
	 */
	public function login(){
		//来源
		$referer = urlencode($_SERVER['HTTP_REFERER']);
		//$this->assign("url",$referer);
		$this->show("<form action='".__URL__."/checkLogin' method='post'><input type='hidden' name='ref' value='{$referer}' /><input type='text' name='user' /><br /><input type='password' name='pass' /><button>登录</button></form>", "utf-8");
		$this->display();
	}
	/**
	 * 验证用户
	 */
	public function checkLogin(){
		$map = array("mem_id"=> addslashes($_POST['user']));
		$info = M("member")->field("mem_password, mem_state")->where($map)->find();
		if($info['mem_password'] == md5($_POST['pass'])){
			
			if($info['mem_state'] == 2){
				$this->error("对不起~您的账户可能由于敏感操作已被锁定！");
			}elseif($info['mem_state']==0){
				$this->error("该账户还未未激活");
			}else{
				$_SESSION['member'] = $_POST['user'];
				M("member")->where($map)->setInc('mem_logincount');
				$this->memberInit();
				$url = empty($_REQUEST['ref']) ? __URL__."/index" : urldecode($_REQUEST['ref']);
				$this->success("登录成功！", $url);
			}
		}else{
			$this->error("用户名或密码错误！");
		}
	}
	
	/**
	 * 注销用户
	 */
	public function logout(){
		unset($_SESSION['member']);
		unset($GLOBALS['member']);
		redirect(__GROUP__."/Member");
	}
	
	/**
	 * 初始化会员
	 */
	private function memberInit(){
		//初始化会员信息
		global $member;
		//更新会员状态
		D('Member')->updateMemberActive();
		if(isset($_SESSION['member']) && !empty($_SESSION['member'])){
			$member['info'] = M("member")->where("mem_id='{$_SESSION['member']}'")->find();
			if(empty($member['info'])){
				unset($_SESSION['member']);
				unset($member);
				redirect(__URL__."/index");exit;
			}
			//检查会员状态
			if($member['info']['mem_active']==1){
				$duefeeNoticeDuration = D("Sysconf")->getConf('cfg_duenotice');
				if($member['info']['mem_expiretime']<$_SERVER['REQUEST_TIME']){
					//更新会员状态
					M("member")->where("mem_id='{$_SESSION['member']}'")->setField("mem_active", 0);
					$member['info']['mem_active'] = 0;
				}else if($member['info']['mem_expiretime']>$_SERVER['REQUEST_TIME']-$duefeeNoticeDuration*24*3600){
					//自动创建续费单并提醒
					D('Duefee')->createDuefee($_SESSION['member']);
				}
			}
			
			//系统消息
			$member['notice'] = D("Notice")->noRead($_SESSION['member']);
		}
	}
	
	/**
	 * 用户条款
	 */
	public function agreement(){
		$this->display();
	}
	
	/**
	 * 注册页
	 */
	public function register(){
		$this->display();
	}
	
	/**
	 * 保存注册信息
	 */
	public function reg(){
		
		$data['mem_id'] = addslashes($_POST['user']);
		$data['mem_password'] = addslashes($_POST['pass']);
		$data['mem_regtime'] = $_SERVER['REQUEST_TIME'];
		if($data['mem_id']==""){
			$this->error('账号不能为空！');
		}elseif($data['mem_password']==''){
			$this->error('密码不能为空！');
		}
		if(M("member")->add($data)){
			//$url = empty($_REQUEST['ref']) ? $_REQUEST['ref'] : __URL__."/index";
			$this->postVerifyMail($member);
			$this->success("注册账号成功！", __URL__."/login");
		}else{
			$this->error("注册失败！");
		}
	}

	/**
	 * 发送验证邮件
	 */
	public function sendVerifyMail(){
		$send = $this->postVerifyMail($_SESSION['member']);
		if($send===true){
			$this->success("邮件发送成功！");
		}elseif($send===false){
			$this->error("邮件发送失败！");
		}else{
			$this->error($send);
		}
	}
	
	/**
	 * 发送验证邮件
	 */
	private function postVerifyMail($member){
		$email = M("member")->where("mem_id='{$member}'")->getField("mem_email");
		if(empty($email)){
			return "不存在的用户或未绑定邮箱！";
		}
		$verify = array("code"=>randomStr(8, 4), "expire"=>time());
		$verify = json_encode_nonull($verify);
		$subject = "[招投网]验证您的电子邮箱地址";
		$body = ":)";
		if(think_send_mail($email, $member, $subject, $body)){
			M("member")->where("mem_id='{$member}'")->setField("mem_verifycode", $verify);
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 验证邮箱有效性,绑定邮箱
	 */
	public function verifyMail($member="", $verifyCode=""){
		$verify = M("member")->where("mem_id='{$member}'")->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = json_decode($verify);
			if($verifyInfo['expire'] > time()-7*24*3600){
				if($verifyCode == $verifyInfo['code']){
					//验证通过
					$_SESSION['member'] = $member;
					$this->success("邮箱验证成功！", __URL__."/index");
				}
			}else{
				$this->error('链接已失效！点击<a href="'.__URL__.'/sendVerifyMail">重新发送验证邮件</a>.', __URL__."/index");
			}
		}else{
			$this->_empty();
		}
	}
	
	/**
	 * 发送短信验证码
	 *
	public function sendMessage($memeber, $tel, $verifyCode){
		
	}
	/**
	 * 绑定手机
	 *
	public function verifyTel($memeber, $verifyCode){
		
	}
	 */
	
	/**
	 * 找回密码
	 */
	public function retrieve($step="1"){
		if(empty($step)){
			$step = "1";
		}
		switch($step){
			case "1":
				$this->display();
				break;
			case "2":
				if(isset($_REQUEST['mid'])){
					$mid = addslashes($_REQUEST['mid']);
					$exist = M("member")->where("mem_id='{$mid}'")->count();
					if(!empty($exist)){
						$this->sendVerifyMail($mid);
					}else{
						$this->error("无效的用户名");
					}
				}else{
					$this->error("请输入用户名");
				}
				break;
			case "3":
				
				break;
			case "4":
				
				break;
			default:
				
		}
	}
	
	/**
	 * 修改密码
	 */
	public function safty($action=""){
		$this->checkMember();
		if($action=="save"){
			
		}else{
			$this->display();
		}
	}
	/**
	 * 修改资料
	 */
	public function myInfo($action=""){
		if($action=="save"){
			
		}
	}
	
	/**
	 * 查看会员资料
	 */
	public function memberInfo($id=""){
		$memberInfo = M("member")->where("mem_id='{$id}'")->find();
		if($memberInfo['mem_state']==2){
			$this->error("对不起, 您说查看的用户可能由于敏感操作被系统锁定。");
		}else{
			//发起项目
			$projects = D("project")->getProjects();
			//项目投标
			$bidders = D("bidder")->getBids();
			$this->assign("info", $memberInfo);
			$this->assign("projects", $projects);
			$this->assign("bidders", $bidders);
		}
	}
	
	/**
	 * 系统通知
	 */
	public function sysNotice(){
		$notices = D("Notice")->getNotic($_SESSION['member']);
		$this->assign("notices", $notices);
		$this->display();
	}
	
	/**
	 * 收藏项目
	 */
	public function proCollection(){
		$collections = D("Collection")->getCollections($_SESSION['member']);
		$this->assign("collections", $collections);
		$this->display();
	}
	
	/**
	 * 充值消费记录
	 */
	public function dueRecord(){
		$duefees = D("Duefee")->getDuefees($_SESSION['member'], 1);
		$this->assign("duefees", $duefees);
		$this->display();
	}
	
}