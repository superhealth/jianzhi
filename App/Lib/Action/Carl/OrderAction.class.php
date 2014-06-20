<?php
/**
 * 年费订单与保证金模块
 */
class OrderAction extends BaseAction{
	/**
	 * 年费续费单
	 */
	public function index(){
		
	}
	
	/**
	 * 添加年费单
	 */
	public function due_add(){
		
	}

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
	 * 退款操作
	 * @param array $chkt 选中id
	 */
	public function deposit_back($chkt=""){
		
	}
}