<?php
/**
 * 系统通知模块
 * @author dapianzi
 *
 */
class NoticeAction extends CommonAction{
	private $typeArr = array(
			'sys'	=> '公 &nbsp;&nbsp; 告',
			'ser'	=> '服务通知',
			'pro'	=> '招方消息',
			'bid'	=> '投方消息',
			'acc'	=> '账户消息',
			''	=>'全 &nbsp;&nbsp; 部'
		);
	/**
	 * 系统通知
	 */
	public function index($type = ''){
		
		$this->checkMember();
		$notices = D("Notice")->notices($_SESSION['member'], $type,2);
		$this->assign("notices", $notices);
		$this->assign('noticeType', $this->typeArr);
		$this->assign('type', $type);
		//dump($notices);
		//$count = D('Notice')->noticeCount($_SESSION['member'], $type);
		//$all = D('Notice')->noticeCount($_SESSION['member']);
		$this->display();
	}
	
	public function view($id=""){
		$notice = M('notice')->where('no_mid="'.$_SESSION['member'].'" AND no_id='.$id)->find();
		$this->assign('notice', $notice);
		$this->display();
	}
	
}