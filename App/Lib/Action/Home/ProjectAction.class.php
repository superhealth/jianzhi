<?php
/**
 * 项目模块
 * @author dapianzi
 *
 */
class ProjectAction extends CommonAction{
	/**
	 * 项目浏览 搜索
	 */
	public function index(){
		
	}
	
	/**
	 * 发布项目
	 * @param $step 步骤
	 */
	public function createProject($step = 1){
		
	}
	

	/**
	 * 项目详情
	 */
	public function viewProject($id=""){
	
	}
	
	/**
	 * 我的当前项目
	 */
	public function myProject(){
		$this->checkMember();
		echo "success";
	}
	
	
	/**
	 * 修改项目
	 */
	public function modifyProject($id=""){
		$this->checkMember();
	}
	
	/**
	 * 取消项目
	 */
	public function cancleProject($id=""){
		$this->checkMember();
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory($id=""){
		$this->checkMember();
	}
	
	/**
	 * 草稿箱
	 */
	public function drafts(){
		$this->checkMember();
	}
}