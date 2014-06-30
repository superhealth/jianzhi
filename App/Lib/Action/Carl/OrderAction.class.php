<?php
/**
 * 年费订单与保证金模块
 */
class OrderAction extends BaseAction{
	/**
	 * 年费续费单
	 */
	public function index(){
		$duefee = M("duefee");
		$map = array(
			"du_paytime" => array("gt", time()-2592000) 	//30*24*3600 默认一个月内
		);
		$param = array();
		//筛选支付方式
		if(isset($_REQUEST['pay']) && $_REQUEST['pay']!="all"){
			if($_REQUEST['pay']=='alipay'){
				$map['du_operator'] = "alipay";
			}else{
				$map['du_operator'] = array("neq", "alipay");
			}
			$param['pay'] = $_REQUEST['pay'];
		}
		//支付状态
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['du_paystatus']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		//查询用户名
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['du_mid']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		//按起止时间查询已支付
		if($map['du_paystatus']!="0"){
			//选择起止时间
			$start = strtotime($_REQUEST['start']);
			$end = strtotime($_REQUEST['end']);
		}
		$this->assign("param", $param);
		$total = $duefee->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//$join = "";
		//$field = "";
		$order = "du_paytime DESC";
		$duefees = $duefee->where($map)->order($order)->limit($limit)->select();
		$this->assign("duefee", $duefee);
		$this->assign("operator", array("alipay"=>"支付宝", "other"=>"线下转账"));
		$this->display();
	}

	/**
	 * 查看续费单详细
	 */
	public function viewDue($id=""){
		$duefee = M("duefee")->where("du_id={$id}")->find();
		if(!empty($duefee)){
			$html = "";
			exit($html);
		}else{
			echo response_msg("参数错误！", "error", true);
		}
	}
	
	/**
	 * 删除续费单
	 */
/* 	public function delDue($id=""){
		if(!empty($id)){
			$map = array("du_id"=>array("in", $id));
			if(M("duefee")->where($map)->delete()){
				$this->watchdog("删除", "删除续费单");
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}
		}else{
			$this->error("没有可删除的选项！");
		}
	} */
	
	/**
	 * 所有保证金
	 */
	public function deposit(){
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
				$where['bid_subject']  = array('like', "%{$words}%");
				$where['de_mid'] = array('like', "%{$words}%");
				$where['_logic']	= "or";
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $deposit->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$join = "zt_bidder ON de_id=bid_sn";
		$field = "zt_deposit.*, bid_id, bid_subject, bid_state";
		$order = "de_createtime DESC";
		$deposits = $deposit->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		$this->assign("deposits", $deposits);
		$this->display();
	}
	
	/**
	 * 退款操作
	 * @param array $chkt 选中id
	 */
	public function depositBack($id=""){
		D("Deposit")->back($id);
	}
	
	public function viewDeposit($id){
		$info = M("deposit")->join("zt_bidder ON bid_sn=de_id")->where('de_id="'.$id.'"')->find();
		dump($info);
		$this->assign("info", $info);
		$this->assign("status", array('未支付', '已支付','已退款','退款失败'));
	}
	
}