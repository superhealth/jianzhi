<?php
/**
 * 投标单管理
 * @author Carl
 *
 */
class BidAction extends BaseAction{
	/**
	 * 所有投标单，筛选
	 */
	public function index(){
		$deposit = M("deposit");
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
		$total = $prop->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$join = "";
		$field = "";
		$order = "";
		$deposits = $deposit->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		$this->assign("deposit", $deposit);
		$this->display();
	}
	
	/**
	 * 未完成标单
	 */
	public function unPublish(){
		$deposit = M("bidder");
		$map = array("bid_state" => 0);
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
		$total = $prop->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$join = "";
		$field = "";
		$order = "";
		$deposits = $deposit->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		$this->assign("deposit", $deposit);
		$this->display();
	}
	
	/**
	 * 查看编辑投标单
	 */
	public function editBid($id=""){
		$join = array(
				"zt_project" 	=> "ON pro_id = bid_proid",
				"zt_member"	=> "ON bid_mid = mem_id"
		);
		$field = "bid.*, pro_name, pro_id ,mem_id";
		$bidInfo = M("bidder")->where("bid_id={$id}")->find();
		if($bidInfo){
			$this->assign("info", $bidInfo);
			$this->display();
		}else{
			$this->error("参数错误！");
		}
	}
	
	/**
	 * 保存修改
	 */
	public function saveBid(){
		$data = M("bidder")->
	}
	
	/**
	 * 历史档案
	 */
	public function history(){
		
	}
	
	/**
	 * 移入历史档案
	 */
	public function toHistory($id=""){
		
	}
	
	/**
	 * 删除投标单
	 */
	public function delBid($id=""){
		
	}
}