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
		$info = M('member')->join('zt_due')->where('')
		$this->assign('expireFlag', 'soon');
		$this->assign('expireDay', D('Sysconf')->getConf('cfg_duenotice'));
		$this->assign('duefee', D('Sysconf')->getConf('cfg_duefee'));
		$this->display();
	}
	
	public function create(){
		$this->checkMember();
		$this->leftInit();
		$id = D('Duefee')->createDuefee($_SESSION['member']);
		$price = D('Sysconf')->getConf('cfg_duefee');
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