<?php
class SubscribeAction extends BaseAction{
	/**
	 * 邮件订阅
	 */
	public function index(){
		$subscribe = M("subscribe");
		$param = array();
		$map = array();
		// 过滤选项
		if(isset($_REQUEST['state']) && $_REQUEST['state']!="all"){
			$map['sub_state'] = $_REQUEST['state'];
			$param['state'] = $_REQUEST['state'];
		}
		if(isset($_REQUEST['cust']) && $_REQUEST['cust']!="all"){
			if($_REQUEST['cust']=="register"){
				$map['sub_customer'] = array("neq", "");
			}else{
				$map['sub_customer'] = array("eq", "");
			}
			$param['cust'] = $_REQUEST['cust'];
		}
		if(isset($_REQUEST['words'])){
			$word = addslashes($_REQUEST['words']);
			if(strlen($word)>=3){
				$where['sub_email']  = array('like', "%{$word}%");
				$where['sub_customer']  = array('like',"%{$word}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $word;
			}
		}
		$this->assign("param", $param);
		// total总数
		$total = $subscribe->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		$subscribes = $subscribe->where($map)->order("sub_time DESC")->select();
		$this->assign("subscribes", $subscribes);
		
		$this->assign("cust", array("register"=>"注册用户", "unregister"=> "未注册用户"));
		$this->assign("state", array("未订阅", "已订阅"));
		$this->display();
	}
	
	/**
	 * 退订
	 */
	public function unsubscribe($sub_id=""){
		if(!per_check("subscribe")){
			$msg = response_msg("操作受限！", "error", true);
		}else{
			if($sub_id){
				$cur_state = M("subscribe")->where("sub_id={$sub_id}")->find();
				$state = $cur_state['sub_state']==1?0:1;
				if(M("subscribe")->where("sub_id={$sub_id}")->setField("sub_state", $state)){
					$this->watchdog("编辑", "修改 {$cur_state['sub_email']} 的邮件订阅状态");
					$msg = response_msg("设置成功！", "success", true);
				}else{
					$msg = response_msg("设置失败！", "error", true);
				}
			}else{
				$msg = response_msg("参数错误", "error", true);
			}
		}
		echo $msg;
	}
	
	/**
	 * 写邮件
	 */
	public function post_email(){
		if(!per_check("post_email")){
			echo "<script type='text/javascript'>alert('Access Denied!'); history.go(-1);</script>";
			exit;
		}
		if($_POST['email_adress']){
			$email_adress = implode(";", $_POST['email_adress']);
			$this->assign("email_adress", $email_adress);
		}
		$email_footer = M("sysconfig")->where("c_key='email_footer'")->getField("c_value");
		$this->assign("email_footer", $email_footer);
		$this->display();
		
	}
	
	/**
	 * 发邮件
	 */
	public function send_email(){
		if(!per_check("post_email")){
			echo "<script type='text/javascript'>alert('Access Denied!'); history.go(-1);</script>";
			exit;
		}
		if($_POST['email_footer_modify']){
			M("sysconfig")->where("c_key='email_footer'")->setField("c_value", $footer);
		}
		$subject = $_POST['email_subject'];
		$content = $_POST['email_content'];
		if($subject == ""){
			$msg = response_msg("EMPTY_SUBJECT");
			redirect(__URL__."/post_email/msg/{$msg}");exit;
		}
		if($content == ""){
			$msg = response_msg("EMPTY_CONTENT");
			redirect(__URL__."/post_email/msg/{$msg}");exit;
		}
		$footer = $_POST['email_footer'];
		$body = $content.$footer;
		$map['sub_state'] = 1;
		if($_POST['email_to']=="all"){
			$to = M("subscribe")->where($map)->getField("sub_email", true);
		}elseif($_POST['email_to']=="register"){
			$map['sub_customer'] = array("neq", "");
			$to = M("subscribe")->where($map)->getField("sub_email", true);
		}elseif($_POST['email_to']=="unregister"){
			$map['sub_customer'] = array("eq", "");
			$to = M("subscribe")->where($map)->getField("sub_email", true);
		}else{
			if(!empty($_POST['email_adress'])){
				$to = explode(";", $_POST['email_adress']);
			}
		}
		$err_msg = "";
		foreach($to as $v){
			$mail_send = think_send_mail($v, "hello", $subject, $body);
			if(true!==$mail_send){
				$err_msg .= $v."发送失败！";
			}
		}
		
		if($err_msg==""){
			$msg = response_msg("OPERATION_SUCCESS", "success");
		}else{
			$msg = response_msg("OPERATION_FAILED");
		}
		redirect(__URL__."/post_email/msg/{$msg}");
	}
	
	
}