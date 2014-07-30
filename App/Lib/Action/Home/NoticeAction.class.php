<?php
/**
 * 系统通知模块
 * @author dapianzi
 *
 */
class NoticeAction extends CommonAction{
	/**
	 * 系统通知
	 */
	public function index($type = ''){
		$this->checkMember();
		$notices = D("Notice")->notices($_SESSION['member'], $type);
		$this->assign("notices", $notices);
		$this->display();
	}
	
	public function view($id=""){
		$notice = M('notice')->where('no_mid="'.$_SESSION['member'].'" AND no_id='.$id)->find();
		$this->assign('notice', $notice);
		$this->display();
	}
	
}