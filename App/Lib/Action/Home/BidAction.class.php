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
		
		
	}

	
	/**
	 * 新建应标
	 * @paramstring $id 项目id
	 * 
	 */
	public function launch($id=""){
		$this->checkMember();
		$proInfo = M('project')->where("pro_id={$id}")->find();
		$this->assign('project'', $proInfo);
		$this->display();
	}
	/**
	 * 保存投标
	 */
	public function save(){
		
		
	}
	
	
	/**
	 * 新建应标成功
	 * @param 
	 */
	public function launchEd(){
		$this->checkMember();
	}
	/**
	 * 新建应标
	 * @param 创建步骤3
	 */
	public function modify(){
		$this->checkMember();
	}
	
	/**
	 * 查看投标信息
	 * @param string $sn 投标序列号
	 */
	public function view($id=""){
		
	}

	/**
	 * 取消投标信息
	 */
	public function cancle(){
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