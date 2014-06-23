<?php
/**
 * 招投项目模块
 * @author Carl
 *
 */
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
	 * 查看编辑项目详情
	 */
	public function editProject($action=""){
		if(!per_check("project_edit")){
			$this->error("无此权限！");
		}
		if($action=="save"){
			
		}else{
			
		}
	}
	
	/**
	 * 历史档案
	 */
	public function history(){
		$history = M("projectrecord");
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
		$historys = M("projectrecord")->select();
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory($id){
		$data = M("project")->where("pro_id={$id}")->find();
		if(M("project")->where("pro_id={$id}")->delete()){
			if(M("projectrecord")->add($data)){
				$this->watchdog("转移", "将项目《{$data['pro_subject']}》移入历史档案区");
				$this->success("移入成功！");
			}else{
				//数据回滚
				M("project")->add($data);
				$this->error("存入档案失败！");
			}
		}else{
			$this->error("移出失败！");
		}
	}
	
	/**
	 * 删除项目
	 */
	public function delProject($id=""){
		$map = array("pro_id"=>array("in", $id));
		$names = M("project")->where($map)->getField("pro_subject", true);
		$atts = M("project")->where($map)->getField("pro_attachment", true);
		$deposit = M("bidder")->join("zt_deposit ON de_sn=bid_sn")->where(array("bid_proid"=>array("in", $id)))->getField("de_id");
		if(M("project")->where($map)->delete()){
			//删除成功，删除附件，退款
			attDelete($atts);
			Alipay::backDeposit($deposit);
			$this->watchdog("删除", "删除项目《".implode("》，《", $names)."》");
			$this->success("删除成功！");
			
		}else{
			$this->error("删除失败！");
		}
	}
	
}