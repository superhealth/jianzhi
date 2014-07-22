<?php
class MemberAction extends CommonAction{
	/**
	 * 用户中心
	 */
	public function index(){
		$this->checkMember();
		$this->memberInit();
		//$this->assign("member", $GLOBALS['member']);
		$member = M("member")->where("mem_id='{$_SESSION['member']}'")->find();
		if($member['mem_type']==0){
			$memberinfo = M("memberperson")->where("mp_mid='{$_SESSION['member']}'")->find();
			$status = $memberinfo['mp_status'];
		}else{
			$memberinfo = M("membercompany")->where("mc_mid='{$_SESSION['member']}'")->find();
			$status = $memberinfo['mc_status'];
		}
		$this->assign('member', $member);
		$this->assign('memberinfo', $memberinfo);
		$this->assign('mstatus', $status);
		$this->display();
	}
	
	/**
	 * 登录页
	 */
	public function login($flag = false){
		//来源
		if($flag){
			$referer = urlencode($_SERVER['HTTP_REFERER']);
		}
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
				$this->error('该账户还未未激活！点击<a href="'.__URL__.'/sendVerifyMail/member/'.$_POST['user'].'">发送验证邮件</a>.', __URL__."/login");
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
		redirect(__URL__."/login");
	}
	
	/**
	 * 初始化会员
	 */
	private function memberInit(){
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
		$data['mem_password'] = md5($_POST['pass']);
		$data['mem_regtime'] = $_SERVER['REQUEST_TIME'];
		$data['mem_email'] = addslashes($_POST['email']);
		$data['mem_type'] = $_POST['type'];
		if($data['mem_id']==""){
			$this->error('账号不能为空！');
		}elseif($data['mem_password']==''){
			$this->error('密码不能为空！');
		}
		$data['mem_state'] = 0;
		$data['mem_logincount'] = 0;
		$data['mem_active'] = 1;
		$freetime = D("Sysconf")->getConf("cfg_freetime");
		$data['mem_expiretime'] = $_SERVER['REQUEST_TIME'] + $freetime*24*3600;
		if(M("member")->add($data)){
			//$url = empty($_REQUEST['ref']) ? $_REQUEST['ref'] : __URL__."/index";
			if($data['mem_type']==0){
				M("memberperson")->add(array('mp_mid'=>$data['mem_id']));
			}else{
				M("membercompany")->add(array('mc_mid'=>$data['mem_id'], 'mc_company'=>addslashes($_POST['com_name'])));
			}
			$mail = preg_replace('/(?<=.{2}).*(?=.{2}@)/', "**",$data['mem_email']);
			$this->success("恭喜你，注册成功！我们已向您的邮箱<b>{$mail}</b>发送验证邮件，请登录该邮箱完成验证。", __URL__."/login",5);
			postVerifyMail($data['mem_id']);exit;
		}else{
			$this->error("注册失败！请联系《订单网》工作人员。");
		}
	}

	/**
	 * 发送验证邮件
	 */
	public function sendVerifyMail($member=""){
		$send = postVerifyMail($member);
		if($send===true){
			$this->success("邮件发送成功！", __URL__."/login");
		}elseif($send===false){
			$this->error("邮件发送失败！", __URL__."/login");
		}else{
			$this->error($send, __URL__."/login");
		}
	}
	
	public function checkUser($name=""){
		if($name){
			$exist = M("member")->where('mem_id="'.$name.'"')->count();
			if($exist>0){
				exit('fail');
			}else{
				exit('ok');
			}
		}else{
			exit("empty");
		}
	}
	
	public function checkCompany($name=""){
		if($name){
			$exist = M("membercompany")->where('mc_company="'.$name.'"')->count();
			if($exist>0){
				exit('fail');
			}else{
				exit('ok');
			}
		}else{
			exit("fail");
		}
	}
	
	
	/**
	 * 验证邮箱有效性,绑定邮箱
	 */
	public function verifyMail($member="", $verifyCode=""){
		$verify = M("member")->where("mem_id='{$member}'")->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = explode("-", $verify);
			if($verifyInfo[1] > time()-7*24*3600){
				if($verifyCode == $verifyInfo[0]){
					//验证通过
					M("member")->where('mem_id="'.$member.'"')->save(array('mem_state'=>1, 'mem_verifycode'=>''));
					$this->success("邮箱验证成功！", __URL__."/login");
				}else{
					$this->_empty();
				}
			}else{
				$this->error('链接已失效！点击<a href="'.__URL__.'/sendVerifyMail/member/{$member}">重新发送验证邮件</a>.', __URL__."/login", 5);
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
		$this->checkMember();
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
		$this->checkMember();
		$notices = D("Notice")->getNotic($_SESSION['member']);
		$this->assign("notices", $notices);
		$this->display();
	}
	
	/**
	 * 收藏项目
	 */
	public function proCollection(){
		$this->checkMember();
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
	
	public function verify($type=""){
		$this->checkMember();
		if($type=="person"){
			$data = M("memberperson")->create();
			$upload = upload($_SESSION['member']);
			if(!$upload[0]){
				if(empty($_REQUEST['fileflag'])){
					$this->error($upload[1]);
				}
			}else{
				$up_data = D("Attachement")->addAtt($upload[1], $_SESSION['member']);
				$data['mp_idscan'] = $up_data['mp_idscan'];
			}
			$data['mp_status'] = 1;
			if(M("memberperson")->where("mp_mid='{$_SESSION['member']}'")->save($data)){
				$this->success('实名验证提交成功！ 验证结果将发至邮箱和本站消息中心，请注意查收！', '__URL__/index');
			}else{
				$this->error('提交到服务器失败！请稍后再试或联系网站工作人员。');
			}
		}else if($type=="company"){
			$data = M("membercompany")->create();
			$upload = upload($_SESSION['member']);
			if(!$upload[0]){
				if(empty($_REQUEST['fileflag'])){
					$this->error($upload[1]);
				}
			}else{
				$up_data = D("Attachement")->addAtt($upload[1], $_SESSION['member']);
				$data['mc_licencescan'] = $up_data['mc_licencescan'];
			}
			$data['mc_status'] = 1;
			if(M("membercompany")->where("mc_mid='{$_SESSION['member']}'")->save($data)){
				$this->success('实名验证提交成功！ 验证结果将发至邮箱和本站消息中心，请注意查收！', '__URL__/index');
			}else{
				$this->error('提交到服务器失败！请稍后再试或联系网站工作人员。');
			}
		}else{
			$type = M("member")->where("mem_id='{$_SESSION['member']}'")->getField("mem_type");
			if($type==1){
				$info = M('membercompany')->where('mc_mid="'.$_SESSION['member'].'"')->find();
				$licencescan = M("attachement")->where("att_id={$info['mc_licencescan']}")->getField("att_path");
				$this->assign('licencescan', $licencescan);
				$this->assign('info', $info);
				$this->display("Member:verifycompany");
			}else{
				$info = M('memberperson')->where('mp_mid="'.$_SESSION['member'].'"')->find();
				$idscan = M("attachement")->where("att_id={$info['mp_idscan']}")->getField("att_path");
				$this->assign('idscan', $idscan);
				$this->assign('info', $info);
				$this->display("Member:verifyperson");
			}
		}
	}
	
	
	
}