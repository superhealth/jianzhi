<?php
/**
 * 投标模块
 * @author Carl
 *
 */
class BidAction extends CommonAction{
	/**
	 * 投标中心，已投项目总览
	 * 
	 */
	public function index(){
		$this->checkMember();
	}
	
	/**
	 * 新建应标
	 * @param string $step 创建步骤
	 */
	public function createBidder($step = 1){
		$this->checkMember();
	}
	
	/**
	 * 查看投标信息
	 * @param string $sn 投标序列号
	 */
	public function viewBidder($sn=""){
		
	}
	
	/**
	 * 修改投标信息
	 */
	public function modifyBidder(){
		$this->checkMember();
	}
	/**
	 * 取消投标信息
	 */
	public function cancleBidder(){
		$this->checkMember();
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory(){
		$this->checkMember();
	}
	
	/**
	 * 草稿箱
	 */
	public function drafts(){
		$this->checkMember();
	}
	
}