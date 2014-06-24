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
		$this->display();
	}
	
	/**
	 * 生成订单
	 * 
	 */
	public function createDueOrder($year, $price){
		
	}
	
	/**
	 * 待支付
	 */
	public function dueOrders(){
		$orders = D("duefee")->getDuefees($_SESSION['member'], 0);	//
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