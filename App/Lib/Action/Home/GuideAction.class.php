<?php
/**
 * 操作指南模块
 * @author Carl
 *
 */
class GuideAction extends CommonAction{
	/**
	 * 引导首页
	 */
	public function index(){
		$this->display();
	}
	
	/**
	 * 企业认证
	 * @param number $step 步骤
	 */
	public function companyCertificate(){
		$this->display();
	}
	
	/**
	 * 发标指南
	 * @param number $step 步骤
	 */
	public function projecting(){
		$this->display();
	}
	
	/**
	 * 投标指南
	 * @param number $step 步骤
	 */
	public function bidding(){
		$this->display();
	}
}