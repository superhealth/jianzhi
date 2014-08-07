<?php
/**
 * 用户充值模块
 * @author dapianzi
 *
 */
class DueAction extends CommonAction{
	/**
	 * 充值中心
	 */
	public function index(){
		$this->checkMember();
		$this->leftInit();
		// 会员信息
		$mInfo = M('member')->where('mem_id="'.$_SESSION['member'].'"')->find();
		$mInfo['mem_type'] = $mInfo['mem_type']=='1' ? '企业' : '个人';
		$this->assign('mInfo', $mInfo);
		// 充值记录
		$records = M('duefee')->where('due_mid="'.$_SESSION['member'].'" AND due_paystatus=1')->order('due_paytime DESC')->select();
		$this->assign('records', $records);
		// 当前状态
		$this->assign('expireInfo', getExpireStatus($mInfo['mem_expiretime']));
		// 年费
		$this->assign('duefee', D('Sysconf')->getConf('cfg_duefee'));
		$this->display();
	}
	
	/**
	 * 发起支付
	 */
	public function create($year=1){
		$this->checkMember();
		$this->leftInit();
		$id = D('Duefee')->createDuefee($_SESSION['member']);
		$dueInfo = M('duefee')->where('due_id="'.$id.'"')->find();
		$dueInfo['duefee'] = $year * D('Sysconf')->getConf('cfg_duefee');
		$expire = M('member')->where('mem_id="'.$_SESSION['member'].'"')->getField('mem_expiretime');
		$dueInfo['expire'] = $expire>$_SERVER['REQUEST_TIME'] ? ($expire + $year*31536000) : ($_SERVER['REQUEST_TIME'] + $year*31536000);
		$this->assign('dueInfo', $dueInfo);
		$this->display();
	}
	
	/**
	 * 生成订单并支付
	 * 
	 */
	public function saveDue(){
		$this->checkMember();
		$where = array(
			'due_id' => addslashes($_POST['id']),
			'due_mie'	=> $_SESSION['member'],
			'due_paystatus'	=> 0
		);
		$data = array(
			'due_invoice_t'	=> $_POST['invoicet'].'|'.$_POST['invoicett'],
			'due_invioce_c'	=> addslashes($_POST['invoicec']),
			'due_invioce_c'	=> addslashes($_POST['invoiceo']),
		);
		//保存发票信息
		if(M('duefee')->where($where)->save($data)){
			exit('success');
		}else{
			exit('fail');
		}
	}
	
	/**
	 * 待支付
	 */
	public function dueOrders(){
		$this->checkMember();
		$orders = D("duefee")->getDuefees($_SESSION['member']);	//
		$this->assign("orders", $orders);
		$this->display();
	}

}