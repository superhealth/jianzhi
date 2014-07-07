<?php
/**
 * 用户充值模块
 * @author Carl
 *
 */
class DueAction extends CommonAction{
	/**
	 * 充值中心
	 */
	public function index(){
		echo '<a href="'.__URL__.'/createDueOrder/year/2" >提交</a>'
	}
	
	/**
	 * 生成订单
	 * 
	 */
	public function createDueOrder($year=1){
		$this->checkMember();
		$id = D('Duefee')->createDuefee($year, $_SESSION['member']);
		$price = D('Sysconf')->getConf('cfg_duefee');
	}
	
	/**
	 * 待支付
	 */
	public function dueOrders(){
		$orders = D("duefee")->getDuefees($_SESSION['member'], 0);	//
		$this->assign("orders", $orders);
		$this->display();
	}
	
	/**
	 * 发起支付
	 */
	public function alipaySubmit(){
		
	}
	
	/**
	 * 接收结果
	 */
	public function alipayNotice(){
		
	}
	
	/**
	 * 返回
	 */
	public function alipayReturn(){
		
	}
}