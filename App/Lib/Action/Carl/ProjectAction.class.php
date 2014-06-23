<?php
class ProjectAction extends BaseAction{
	/**
	 * 所有项目
	 */
	public function index(){
		$project = M("project");
		$map = array(
				"pro_status" => array("gt", 0)
		);
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
		$join = array(
				"zt_bidder ON pro_id=bid_proid",
				"zt_member ON pro_mid=mem_id",
				"zt_sort ON pro_sort=sort_id",
				"zt_property ON pro_prop=pp_id"
		);
		$field = "";
		$order = "";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		//dump($project->getLastSql());
		//dump($projects);exit;
		$this->assign("projects", $projects);
		$this->display();
	}
	
	/**
	 * 未发布项目
	 */
	public function unPublish(){
		$project = M("project");
		$map = array(
				"pro_status" => 0
		);
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
		$join = array(
				"zt_bidder ON pro_id=bid_proid",
				"zt_member ON pro_mid=mem_id",
				"zt_sort ON pro_sort=sort_id",
				"zt_property ON pro_prop=pp_id"
		);
		$field = "";
		$order = "";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		//dump($project->getLastSql());
		//dump($projects);exit;
		$this->assign("projects", $projects);
		$this->display();
	}
	
	/**
	 * 编辑修改
	 */
	public function editProject($action=""){
		if(!per_check("project_edit")){
			$this->error("无此权限！");
		}
		if($action=="save"){
			
		}
	}
	
	/**
	 * 历史档案
	 */
	public function history(){
		
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory($id){
		$data = M("project")->where("pro_id={$id}")->find();
		if(M("project")->where("pro_id={$id}")->delete()){
			if(M("projectrecord")->add($data)){
				$this->watchdog("转移", "");
				$this->success("移入成功！");
			}else{
				
			}
		}
	}
	
	/**
	 * 删除项目
	 */
	public function delProject(){
		
	}
	
}