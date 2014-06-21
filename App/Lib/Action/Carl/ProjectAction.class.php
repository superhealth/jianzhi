<?php
class ProjectAction extends BaseAction{
	/**
	 * 所有项目
	 */
	public function index(){
		$project = M("project");
		$map = array();
		$param = array();
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['de_paystatus']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['pp_name']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $project->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$join = "";
		$field = "";
		$order = "";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		$this->assign("projects", $projects);
		$this->display();
	}
	
	/**
	 * 未发布项目
	 */
	public function unPublish(){
		
	}
	
	/**
	 * 编辑修改
	 */
	public function editProject(){
		
	}
	
	/**
	 * 历史档案
	 */
	public function history(){
		
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory(){
		
	}
	
	/**
	 * 删除项目
	 */
	public function delProject(){
		
	}
	
}