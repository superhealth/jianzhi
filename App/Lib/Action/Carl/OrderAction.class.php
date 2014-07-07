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
			"due_createtime" => array("gt", time()-2592000) 	//30*24*3600 默认一个月内
		);
		$param = array();
		//筛选支付方式
		if(isset($_REQUEST['pay']) && $_REQUEST['pay']!="all"){
			if($_REQUEST['pay']=='alipay'){
				$map['due_operator'] = "alipay";
			}else{
				$map['due_operator'] = array("neq", "alipay");
			}
			$param['pay'] = $_REQUEST['pay'];
		}
		//支付状态
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['due_paystatus']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		//查询用户名
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['due_mid']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		//按时间段筛选
		if(empty($_REQUEST['start'])){
			$start = 0;
		}else{
			$start = strtotime($_REQUEST['start']);
			$param['start'] = $_REQUEST['start'];
		}
		if(empty($_REQUEST['end'])){
			$end = time();
		}else{
			$end = strtotime($_REQUEST['end']);
			if($start>$end){
				$end = time();
			}else{
				$param['end'] = $_REQUEST['end'];
			}
		}
		$map['due_createtime'] = array("between", $start.','.$end);
		$this->assign("param", $param);
		$total = $duefee->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//$join = "";
		//$field = "";
		$order = "due_paytime DESC";
		$duefees = $duefee->where($map)->order($order)->limit($limit)->select();
		$this->assign("duefees", $duefees);
		$this->assign("operator", array("alipay"=>"支付宝", "other"=>"线下转账"));
		$this->display();
	}

	/**
	 * 查看续费单详细
	 */
	public function viewDue($id=""){
		$status = array('未支付', '已支付','已退款','退款失败');
		$info = M("duefee")->join("zt_bidder ON bid_sn=de_id")->where('de_id="'.$id.'"')->find();
		echo '<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>查看保证金详细</h3>
			</div>
			<div class="modal-body form-horizontal" style="overflow:auto;">
				<fieldset>
					<div class="control-group">
					  	<label class="control-label" for="de_id">保证金订单号：</label>
					  	<div class="controls">
							<h4>'.$info['de_id'].'</h4>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="mem_id">发起人：</label>
					  	<div class="controls">
							<a href="__GROUP__/Member/memberInfo/id/'.$info['de_mid'].'" data-rel="tooltip" data-original-title="查看用户资料">'.$info['de_mid'].'</a>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="bid_subject">应标主题：</label>
					  	<div class="controls">
							<a href="'.__GROUP__.'/Bid/editBidder/id/'.$info['bid_id'].'" data-rel="tooltip" data-original-title="查看应标详情">'.$info['bid_subject'].'</a>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="deposit">应标主题：</label>
					  	<div class="controls">
							<span class="yellow">'.$info['de_deposit'].'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="createtime">创建时间：</label>
					  	<div class="controls">
							<span class="">'.timeFormat($info['de_createtime'], 'Y-m-d').'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="paystatus">交易状态：</label>
					  	<div class="controls">
							<span class="label lable'.switchDeStatus($info['de_paystatus']).'">'.$status[$info['de_paystatus']].'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="paytime">付款时间：</label>
					  	<div class="controls">
							<span class="">'.timeFormat($info['de_paytime'], 'Y-m-d').'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="backtime">退款时间：</label>
					  	<div class="controls">
							<span class="">'.timeFormat($info['de_backtime'], 'Y-m-d').'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="bid_subject">支付宝状态码：</label>
					  	<div class="controls">
							<span class="red">'.$info['de_backcode'].'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="bid_log">状态记录：</label>
					  	<div class="controls">
							<div class="well">'.$info['de_log'].'</div>
					  	</div>
					</div>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
			</div>';
		exit;
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
		//按支付状态查询
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['de_paystatus']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		//关键字搜索应标标题和用户名
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
		//按时间段筛选
		if(empty($_REQUEST['start'])){
			$start = 0;
		}else{
			$start = strtotime($_REQUEST['start']);
			$param['start'] = $_REQUEST['start'];
		}
		if(empty($_REQUEST['end'])){
			$end = time();
		}else{
			$end = strtotime($_REQUEST['end']);
			if($start>$end){
				$end = time();
			}else{
				$param['end'] = $_REQUEST['end'];
			}
		}
		$map['de_createtime'] = array("between", $start.','.$end);
		//保存参数
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
		$this->assign("status", array('未支付', '已支付','已退款','退款失败'));
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
		$status = array('未支付', '已支付','已退款','退款失败');
		$info = M("deposit")->join("zt_bidder ON bid_sn=de_id")->where('de_id="'.$id.'"')->find();
		echo '<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>查看保证金详细</h3>
			</div>
			<div class="modal-body form-horizontal" style="overflow:auto;">
				<fieldset>
					<div class="control-group">
					  	<label class="control-label" for="de_id">保证金订单号：</label>
					  	<div class="controls">
							<h4>'.$info['de_id'].'</h4>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="mem_id">发起人：</label>
					  	<div class="controls">
							<a href="__GROUP__/Member/memberInfo/id/'.$info['de_mid'].'" data-rel="tooltip" data-original-title="查看用户资料">'.$info['de_mid'].'</a>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="bid_subject">应标主题：</label>
					  	<div class="controls">
							<a href="'.__GROUP__.'/Bid/editBidder/id/'.$info['bid_id'].'" data-rel="tooltip" data-original-title="查看应标详情">'.$info['bid_subject'].'</a>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="deposit">应标主题：</label>
					  	<div class="controls">
							<span class="yellow">'.$info['de_deposit'].'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="createtime">创建时间：</label>
					  	<div class="controls">
							<span class="">'.timeFormat($info['de_createtime'], 'Y-m-d').'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="paystatus">交易状态：</label>
					  	<div class="controls">
							<span class="label lable'.switchDeStatus($info['de_paystatus']).'">'.$status[$info['de_paystatus']].'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="paytime">付款时间：</label>
					  	<div class="controls">
							<span class="">'.timeFormat($info['de_paytime'], 'Y-m-d').'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="backtime">退款时间：</label>
					  	<div class="controls">
							<span class="">'.timeFormat($info['de_backtime'], 'Y-m-d').'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="bid_subject">支付宝状态码：</label>
					  	<div class="controls">
							<span class="red">'.$info['de_backcode'].'</span>
					  	</div>
					</div>
					<div class="control-group">
					  	<label class="control-label" for="bid_log">状态记录：</label>
					  	<div class="controls">
							<div class="well">'.$info['de_log'].'</div>
					  	</div>
					</div>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
			</div>';
		exit;
	}
	
}