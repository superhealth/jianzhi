<?php
/**
 * 系统通知模块
 * @author dapianzi
 *
 */
class NoticeAction extends CommonAction{
	private $typeArr = array(
			'sys'		=> '公 &nbsp;&nbsp; 告',
			'ser'		=> '服务通知',
			'pro'	=> '招方消息',
			'bid'	=> '投方消息',
			'acc'	=> '账户消息',
			' '			=>'全 &nbsp;&nbsp; 部'
		);
	/**
	 * 系统通知
	 */
	public function index($type = ''){
		$this->checkMember();
		$this->leftInit();
		$notices = D("Notice")->notices($_SESSION['member'], $type, 8);
		$this->assign("notices", $notices);
		$this->assign('noticeType', $this->typeArr);
		$this->assign('type', $type);
		//dump($notices);
		//$count = D('Notice')->noticeCount($_SESSION['member'], $type);
		//$all = D('Notice')->noticeCount($_SESSION['member']);
		$this->display();
	}
	
	public function view($id=""){
		$this->checkMember();
		$this->leftInit();
		$notice = M('notice')->where('no_mid="'.$_SESSION['member'].'" AND no_id='.$id)->find();
		if(empty($notice)){
			$this->display('notice404');exit;
		}
		D('Notice')->read($id);
		$this->assign('notice', $notice);
		$no_next = M('notice')->where('no_mid="'.$_SESSION['member'].'" AND no_time>'.$notice['no_time'])->order('no_time')->limit(1)->getField('no_id');
		$no_prev = M('notice')->where('no_mid="'.$_SESSION['member'].'" AND no_time<'.$notice['no_time'])->order('no_time DESC')->limit(1)->getField('no_id');
		$this->assign('no_next', $no_next);
		$this->assign('no_prev', $no_prev);
		$this->display();
	}
	
	
	public function read(){
		if(empty($_POST['id'])){
			exit('您未选中任何消息！');
		}else{
			if(D('Notice')->read($_POST['id'])){
				exit('success');
			}else{
				exit('操作失败！');
			}
		}
	}
	
	
	public function del(){
		if(empty($_POST['id'])){
			exit('您未选中任何消息！');
		}else{
			if(M('Notice')->where(array('no_id'=> array('in', $_POST['id'])))->delete()){
				exit('success');
			}else{
				exit('操作失败！');
			}
		}
	}
	
}