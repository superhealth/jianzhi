<?php
/**
 * 招投项目模块
 * @author dapianzi
 *
 */
class ProjectAction extends BaseAction{
	
	private $status = array("0"=> "未发布", "1"=> "招标中", "2"=> "已开标", "关闭"); 	//项目状态
	
	/**
	 * 所有已发布项目
	 */
	public function index(){
		$project = M("project");
		$map = array(
				"pro_status" => array("gt", 0)
		);
		$param = array();
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['pro_status']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		if(isset($_REQUEST['prop']) && $_REQUEST['prop']!="all"){
			$map['pro_prop']  = $_REQUEST['prop'];
			$param['prop'] = $_REQUEST['prop'];
		}
		if(isset($_REQUEST['sort']) && $_REQUEST['sort']!="all"){
			$map['pro_sort']  = $_REQUEST['sort'];
			$param['sort'] = $_REQUEST['sort'];
		}
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['pro_subject']  = array('like', "%{$words}%");
				$where['pro_mid'] = array('like', "%{$words}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
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
				"(SELECT bid_proid,count(*) bidders FROM zt_bidder GROUP BY bid_proid) b ON pro_id=b.bid_proid",
				"zt_sort ON pro_sort=sort_id",
				"zt_property ON pro_prop=pp_id"
		);
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, sort_name, pp_name, pro_publishtime, pro_status, bidders";
		$order = "pro_publishtime DESC";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		//dump($project->getLastSql());
		//dump($projects);exit;
		array_shift($this->status);
		$this->assign("status", $this->status);
		$this->assign("projects", $projects);
		//所有分类
		$sorts = M("sort")->getField("sort_name", true);
		$this->assign("sorts", $sorts);
		//所有属性
		$props = M("property")->getField("pp_name", true);
		$this->assign("props", $props);
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
				"zt_sort ON pro_sort=sort_id",
				"zt_property ON pro_prop=pp_id"
		);
		$field = "";
		$order = "pro_publishtime DESC";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		//dump($project->getLastSql());
		dump($projects);exit;
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
			if(isset($_REQUEST['id'])){
				$info = M("project")->where("pro_id={$_REQUEST['id']}")->find();
				$this->assign("info", $info);
				$this->assign("status", $this->status);
				//所有分类
				$sorts = M("sort")->getField("sort_name", true);
				$this->assign("sorts", $sorts);
				//所有属性
				$props = M("property")->getField("pp_name", true);
				$this->assign("props", $props);
				$areas = D("Area")->Areas();
				$this->display();
			}else{
				$this->error("参数错误！");
			}
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