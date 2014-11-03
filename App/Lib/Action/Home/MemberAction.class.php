<?php
/**
 * 用户模块
 * @author dapianzi
 *
 */
class MemberAction extends CommonAction{
	/**
	 * 用户中心
	 */
	private $types = array('个人', '企业');
	public function index(){
		$this->checkMember();
		$this->memberInit();
		$member = M("member")->where("mem_id='{$_SESSION['member']}'")->find();
		if($member['mem_type']==0){
			$memberinfo = M("memberperson")->where("mp_mid='{$_SESSION['member']}'")->find();
			$status = $memberinfo['mp_status'];
			$memberinfo['place'] = areaToSelect(areaDecode($memberinfo['mp_addr']));
		}else{
			$memberinfo = M("membercompany")->where("mc_mid='{$_SESSION['member']}'")->find();
			$status = $memberinfo['mc_status'];
			$memberinfo['place'] = areaToSelect(areaDecode($memberinfo['mc_addr']));
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
			$this->assign("ref",$referer);
		}
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
				if($_REQUEST['url']=='1'){
					$url = '';
				}else if (!empty($_REQUEST['ref'])){
					$url = $_REQUEST['ref'];
				}else{
					$url = __URL__."/index";
				}
				$this->success("登录成功！", urldecode($url));
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
		$this->success('注销成功！', __APP__, 1);
	}
	
	/**
	 * 初始化会员
	 */
	private function memberInit(){
		//更新会员状态
		D('Member')->updateMemberActive();
		if(isset($_SESSION['member']) && !empty($_SESSION['member'])){
			$member = M("member")->where("mem_id='{$_SESSION['member']}'")->find();
			if(empty($member)){
				unset($_SESSION['member']);
				unset($member);
				redirect(__URL__."/index");exit;
			}
			//检查会员状态
			if($member['mem_active']==1){
				$duefeeNoticeDuration = D("Sysconf")->getConf('cfg_duenotice');
				if($member['mem_expiretime']<$_SERVER['REQUEST_TIME']){
					//更新会员状态
					D("Member")->expired($_SESSION['member']);
					$member['mem_active'] = 0;
				}else if($member['mem_expiretime']>$_SERVER['REQUEST_TIME']-$duefeeNoticeDuration*24*3600){
					//自动创建续费单并提醒
					$subject = '年费过期提醒';
					$content = $_SESSION['member'].' 您好，您的会员将于'.date('Y年m月d日', $member['mem_expiretime']).'到期。请及时续费以继续使用《订单网》的服务，点此<a href="/Due">立即续费</a>。';
					$type = 'acc';
					D('Notice')->sendNotice($_SESSION['member'], $subject, $content, $type);
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
		//$this->error("注册失败！", "", 99);exit;
		if(M("member")->add($data)){
			//$url = empty($_REQUEST['ref']) ? $_REQUEST['ref'] : __URL__."/index";
			if($data['mem_type']==0){
				M("memberperson")->add(array('mp_mid'=>$data['mem_id']));
			}else{
				M("membercompany")->add(array('mc_mid'=>$data['mem_id'], 'mc_company'=>addslashes($_POST['com_name'])));
			}
			$mail = emailToHide($data['mem_email']);
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
		if($_SERVER['REQUEST_TIME']-$_SESSION['emailVerifyTime']<180){
			$this->error('您的操作太过频繁，请稍后再试！');
		}
		$send = postVerifyMail($member);
		if($send===true){
			$this->success("邮件发送成功！");
		}elseif($send===false){
			$this->error("邮件发送失败！");
		}else{
			$this->error($send);
		}
	}
	/**
	 * ajax检查用户名 $email是否重复
	 * @param string $email 待检查的用户名
	 */
	public function checkEmail($email=""){
		if($email){
			$exist = M("member")->where('mem_email="'.$email.'"')->count();
			if($exist>0){
				exit('fail');
			}else{
				exit('ok');
			}
		}else{
			exit("empty");
		}
	}
	
	/**
	 * ajax检查用户名 $name是否重复
	 * @param string $name 待检查的用户名
	 */
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
	/**
	 * ajax 检查公司名字 $name是否重复
	 * @param string $name 待检查的公司名
	 */
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
	 * @param string $member 用户名
	 * @param string $verifyCode 验证码
	 */
	public function verifyMail($member="", $verifyCode=""){
		// 获取服务器端保存的用户验证码
		$verify = M("member")->where("mem_id='{$member}'")->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = explode("-", $verify);
			// 检查是否过期 过期时间7天
			if($verifyInfo[1] > time()-7*24*3600){
				if($verifyCode == $verifyInfo[0]){
					//验证通过
					$verifyInfo[1] = 0;
					M("member")->where('mem_id="'.$member.'"')->save(array('mem_state'=>1, 'mem_verifycode'=>implode('-', $verifyInfo)));
					$email = M("member")->where("mem_id='{$member}'")->getField("mem_email");
					$subject = '邮箱验证通知';
					$content = '恭喜您已通过邮箱验证，绑定的邮箱地址是：'.emailToHide($email);
					$type = '服务通知';
					// 发送消息
					D('Notice')->sendNotice($member, $subject, $content, $type);
					$this->success("邮箱验证成功！", __URL__."/index");
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
	 * 安全中心
	 */
	public function safety(){
		$this->checkMember();
		$this->leftInit();
		$mInfo = M('member')->where('mem_id="'.$_SESSION['member'].'"')->find();
		$mInfo['email'] = emailToHide($mInfo['mem_email']);
		$this->assign('mInfo', $mInfo);
		$this->display();
	}
	
	public function checkSafeCode(){

		if(empty($_SESSION['member'])){
			exit('error');
		}
		$code = addslashes($_GET['code']);
		$check = D('Member')->checkVerifyCode($_SESSION['member'], $code);
		if($check!==true){
			exit('error');
		}else{
			//验证通过
			$_SESSION['safeCode'] = $_SESSION['member'];
			exit('success');
		}
	}
	
	public function checkSafe(){
		$resJson = array('code'=>0, 'msg'=>'');
		if(!$_SESSION['member']){
			$resJson['code'] = 5;
			echo json_encode_nonull($resJson);exit;
		}
		if(empty($_SESSION['safeCode'])||$_SESSION['safeCode']!==$_SESSION['member']){
			if($_SERVER['REQUEST_TIME']-$_SESSION['emailSendTime']<180){
				$resJson['code'] = 1;
				$resJson['time'] = 180-$_SERVER['REQUEST_TIME']+$_SESSION['emailSendTime'];
				echo json_encode_nonull($resJson);exit;
			}
			$send = verifyCode($_SESSION['member']);
			if($send===true){
				$resJson['code'] = 1;
				$resJson['time'] = 180;
				echo json_encode_nonull($resJson);exit;
			}elseif($send===false){
				$resJson['code'] = 2;
				$resJson['msg'] = '邮件发送失败！';
				echo json_encode_nonull($resJson);exit;
			}else{
				$resJson['code'] = 2;
				$resJson['msg'] = $send;
				echo json_encode_nonull($resJson);exit;
			}
		}else{
			echo json_encode_nonull($resJson);exit;
		}
	}
	
	public function reCode(){
		if(empty($_SESSION['member'])){
			exit('Access Denied!');
		}
		if($_SERVER['REQUEST_TIME']-$_SESSION['emailSendTime']<180){
			exit('您的操作太过频繁，请稍后再试！');
		}
		$send = verifyCode($_SESSION['member']);
		if($send===true){
			exit('ok');
		}elseif($send===false){
			exit('安全码邮件发送失败，请稍后再试！');
		}else{
			exit($send);
		}
		
	}
	/**
	 * 修改邮箱页面
	 */
	public function chemail(){
		$this->checkMember();
		$this->leftInit();
		if(empty($_SESSION['safeCode'])||$_SESSION['safeCode']!==$_SESSION['member']){
			redirect(__URL__.'/safety');exit;
		}
		$this->display();
	}
	
	public function chEmailStep2(){
		$this->checkMember();
		$this->leftInit();
		if(empty($_SESSION['safeCode'])||$_SESSION['safeCode']!==$_SESSION['member']){
			redirect(__URL__.'/safety');exit;
		}
		if($_SERVER['REQUEST_TIME']-$_SESSION['emailVerifyTime']<180){
			$this->error('您的操作太过频繁，请稍后再试！');
		}
		$send = postChangeMail($_SESSION['member'], $_POST['new_email']);
		if($send===true){
			$_SESSION['changeEmail'] = $_POST['new_email'];
			$this->display();
		}elseif($send===false){
			$this->error("邮件发送失败！");
		}else{
			$this->error($send);
		}
	}
	
	public function reChangeEmail(){
		if(!empty($_SESSION['safeCode'])&&$_SESSION['safeCode']!==$_SESSION['member']){
			exit('身份错误！请刷新页面再试。');
		}
		if($_SERVER['REQUEST_TIME']-$_SESSION['emailVerifyTime']<180){
			exit('您的操作太过频繁，请稍后再试！');
		}
		$send = postChangeMail($_SESSION['member'], $_POST['email']);
		if($send===true){
			exit("邮件发送成功！");
		}elseif($send===false){
			exit("邮件发送失败！");
		}else{
			exit($send);
		}
		
	}
	/**
	 * 验证新邮箱是否有效
	 * @param string $code 验证邮箱有效性的安全码
	 */
	public function changeEmail($code=''){
		if(!$_SESSION['member']||!$_SESSION['changeEmail']){
			$this->error('链接已失效！');
		}
		// 获取服务器端保存的用户验证码
		$verify = M("member")->where('mem_id="'.$_SESSION['member'].'"')->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = explode("-", $verify);
			// 检查是否过期 过期时间7天
			if($verifyInfo[1] > time()-7*24*3600){
				if($code == $verifyInfo[0]){
					//验证通过
					$verifyInfo[1] = 0;
					$data = array(
							'mem_email'=>$_SESSION['changeEmail'], 
							'mem_verifycode'=>implode('-', $verifyInfo)
						);
					if(M("member")->where('mem_id="'.$_SESSION['member'].'"')->save($data)){
						unset($_SESSION['safeCode']);
						$subject = '邮箱修改成功通知';
						$email = emailToHide($_SESSION['changeEmail']);
						$content = '恭喜您已通过邮箱验证完成邮箱修改，绑定的邮新箱地址是：'.$email;
						$type = '服务通知';
						// 发送消息
						D('Notice')->sendNotice($_SESSION['member'], $subject, $content, $type);
						$this->success("您的新邮箱<strong>{$email}</strong>绑定成功！", __URL__."/index");;
					}else{
						$this->error('新邮箱修改失败！', __APP__);
					}
					
				}else{
					$this->_empty();
				}
			}else{
				$this->_empty();
			}
		}else{
			$this->_empty();
		}
	}
	
	public function chpw(){
		$this->checkMember();
		$this->leftInit();
		if(empty($_SESSION['safeCode'])||$_SESSION['safeCode']!==$_SESSION['member']){
			redirect(__URL__.'/safety');exit;
		}
		$this->display();
	}
	
	public function chpwEd(){
		$this->checkMember();
		$this->leftInit();
		if(empty($_SESSION['safeCode'])||$_SESSION['safeCode']!==$_SESSION['member']){
			redirect(__URL__.'/safety');exit;
		}
		if(M('member')->where('mem_id="'.$_SESSION['member'].'"')->setField('mem_password', md5($_POST['newpass']))){
			unset($_SESSION['safeCode']);
			$subject = '密码修改成功通知';
			$content = '恭喜您已成功修改登录密码';
			$type = '服务通知';
			// 发送消息
			D('Notice')->sendNotice($_SESSION['member'], $subject, $content, $type);
			$this->display();
		}else{
			$this->error('修改密码失败！请不要输入之前使用过的密码！');
			
		}
	}
	/**
	 * 修改资料
	 */
	public function myInfo($action=""){
		$this->checkMember();
		$this->leftInit();
		$type = M("member")->where('mem_id="'.$_SESSION['member'].'"')->getField('mem_type');
		if($type=='1'){
			$info = M('member')->join('zt_membercompany ON mem_id=mc_mid')->where('mem_id="'.$_SESSION['member'].'"')->find();
			$info['place'] = areaToSelect(areaDecode($info['mc_addr']));
		}else{
			$info = M('member')->join('zt_memberperson ON mem_id=mp_mid')->where('mem_id="'.$_SESSION['member'].'"')->find();
			$info['place'] = areaToSelect(areaDecode($info['mp_addr']));
		}
		$this->assign('type', $type);
		$this->assign('info', $info);
		$this->assign('types', $this->types);
		$this->display();
	}
	
	public function saveCom(){
		$this->checkMember();
		$this->leftInit();
		$data = M('membercompany')->create();
		$data['mc_addr'] = areaEncode($_POST['area']);
		if(M('membercompany')->where('mc_mid="'.$_SESSION['member'].'"')->save($data)){
			$this->success('修改成功！');
		}else{
			$this->error('修改失败！');
		}
		
	}
	
	public function savePer(){
		$this->checkMember();
		$this->leftInit();
		$data = M('memberperson')->create();
		$data['mp_addr'] = areaEncode($_POST['area']);
		if(M('memberperson')->where('mp_mid="'.$_SESSION['member'].'"')->save($data)){
			$this->success('修改成功！');
		}else{
			$this->error('修改失败！');
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
	
	
	/**
	 * 实名验证
	 * @param string $type 实名验证类别 个人或者企业
	 */
	public function verify($type=""){
		$this->checkMember();
		if($type=="person"){
			$data = M("memberperson")->create();
			$data['mp_addr'] = areaEncode($_POST['area']);
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
				$this->success('实名验证提交成功！ 验证结果将在3-5个工作日内发至本站消息中心，请注意查收！', '__URL__/index');
			}else{
				$this->error('提交到服务器失败！请稍后再试或联系网站工作人员。');
			}
		}else if($type=="company"){
			$data = M("membercompany")->create();
			$data['mc_addr'] = areaEncode($_POST['area']);
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
				$this->success('实名验证提交成功！ 验证结果将在3-5个工作日内发至本站消息中心，请注意查收！', '__URL__/index');
			}else{
				$this->error('提交到服务器失败！请稍后再试或联系网站工作人员。');
			}
		}else{
			$type = M("member")->where("mem_id='{$_SESSION['member']}'")->getField("mem_type");
			if($type==1){
				$info = M('membercompany')->where('mc_mid="'.$_SESSION['member'].'"')->find();
				$info['place'] = areaToSelect(areaDecode($info['mc_addr']));
				$licencescan = M("attachement")->where("att_id={$info['mc_licencescan']}")->getField("att_path");
				$this->assign('licencescan', $licencescan);
				$this->assign('info', $info);
				$this->display("Member:verifycompany");
			}else{
				$info = M('memberperson')->where('mp_mid="'.$_SESSION['member'].'"')->find();
				$info['place'] = areaToSelect(areaDecode($info['mp_addr']));
				$idscan = M("attachement")->where("att_id={$info['mp_idscan']}")->getField("att_path");
				$this->assign('idscan', $idscan);
				$this->assign('info', $info);
				$this->display("Member:verifyperson");
			}
		}
	}
	
	public function view($id){
		$member = M("member")->where('mem_id="'.$id.'"')->find();
		if($member['mem_type']=='1'){
			$info = M('member')->join('zt_membercompany ON mem_id=mc_mid')->where('mem_id="'.$id.'"')->find();
			$member['place'] = $info['mc_addr'];
		}else{
			$info = M('member')->join('zt_memberperson ON mem_id=mp_mid')->where('mem_id="'.$id.'"')->find();
			$member['place'] = $info['mp_addr'];
		}
		$this->assign('info', $member);
		unset($info);
		$this->assign('types', $this->types);
		$this->display();
	}
}