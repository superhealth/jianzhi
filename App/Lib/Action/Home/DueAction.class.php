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
		$mInfo['mem_type'] = $info['mem_type']=='1' ? '企业' : '个人';
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
	public function create(){
		$this->checkMember();
		$this->leftInit();
		$id = D('Duefee')->createDuefee($_SESSION['member']);
		dump($id);
		$price = D('Sysconf')->getConf('cfg_duefee');
		$this->display();
	}
	
	/**
	 * 生成订单
	 * 
	 */
	public function save(){
		$this->checkMember();
		
		
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