<?php
/**
 * 投标管理模块
 * @author dapianzi
 *
 */
class BidAction extends BaseAction{
	private $status = array("未支付", "已支付", "已退款","退款失败");		//保证金支付状态
	private $state = array("未发布","应标中","备选","中标");		//应标单状态
	private $flags = array(0=>"不公开", 1=>"公开" );
	/**
	 * 所有投标单，筛选
	 */
	public function index(){
		$bidder = M("bidder");
		$map = array();
		$param = array();
		//筛选支付状态
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['bid_paystatus']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		//筛选应标单状态
		if(isset($_REQUEST['state']) && $_REQUEST['state']!="all"){
			$map['bid_state']  = $_REQUEST['state'];
			$param['state'] = $_REQUEST['state'];
		}
		//按应标主题或用户查找
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['bid_subject']  = array('like', "%{$words}%");
				$where['bid_mid'] = array('like', "%{$words}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $bidder->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$join = "zt_deposit ON bid_sn=de_id";
		$field = "zt_bidder.*, LEFT(bid_subject, 20) subject, zt_deposit.de_deposit, zt_deposit.de_paystatus";
		$order = "bid_publishtime DESC";
		$bidders = $bidder->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		//dump($bidders);
		//dump($bidder->getLastSql());
		$this->assign("bidders", $bidders);
		//应标状态
		$this->assign("state", $this->state);
		//支付状态
		$this->assign("paystatus", $this->status);
		$this->display();
	}
	
	/**
	 * 未完成标单
	 */
	public function unPublish(){
		$bidder = M("bidder");
		$map = array("bid_state" => 0);
		$param = array();

		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['pp_name']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $bidder->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		
		$order = "";
		$deposits = $bidder->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		$this->assign("deposit", $deposit);
		$this->display();
	}
	
	/**
	 * 查看编辑投标单
	 */
	public function editBidder($id=""){
		$join = "zt_project ON pro_id = bid_proid";
		$field = "zt_bidder.*, pro_subject, pro_id";
		$bidInfo = M("bidder")->field($field)->join($join)->where("bid_id={$id}")->find();
		$quoted = M("attachement")->where("att_id='{$bidInfo['bid_quoted']}'")->find();
		$tenders = M("attachement")->where("att_id='{$bidInfo['bid_tenders']}'")->find();
		if($bidInfo){
			$this->assign("info", $bidInfo);
			$this->assign("state", $this->state);
			$this->assign("status", $this->status);
			$this->assign("flags", $this->flags);
			$this->display();
		}else{
			$this->error("参数错误！");
		}
	}
	
	/**
	 * 保存修改
	 */
	public function saveBid(){
		
	}
	
	public function saveContace($id=""){
		$count = M("bidder")->where("bid_id='{$id}'")->count();
		if($count!=1){
			$this->error("参数错误！");
		}
		if($cid = D("Contact")->saveContact()){
			M("bidder")->where("bid_id='{$id}'")->setField("bid_contact", $cid);
			$this->success("保存成功！");
		}else{
			$this->error("保存失败！");
		}
	}
	
	/**
	 * 历史档案
	 */
	public function history(){
		$bidder = M("bid_record");
		$map = array();
		$param = array();
		//筛选支付状态
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['bid_paystatus']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		//筛选应标单状态
		if(isset($_REQUEST['state']) && $_REQUEST['state']!="all"){
			$map['bid_state']  = $_REQUEST['state'];
			$param['state'] = $_REQUEST['state'];
		}
		//按应标主题或用户查找
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['bid_subject']  = array('like', "%{$words}%");
				$where['bid_mid'] = array('like', "%{$words}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $bidder->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$join = "zt_deposit ON bid_sn=de_id";
		$field = "zt_bidder.*, LEFT(bid_subject, 20) subject, zt_deposit.de_deposit, zt_deposit.de_paystatus";
		$order = "bid_publishtime DESC";
		$bidders = $bidder->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		//dump($bidders);
		//dump($bidder->getLastSql());
		$this->assign("historys", $bidders);
		//应标状态
		$this->assign("state", $this->state);
		//支付状态
		$this->assign("paystatus", $this->status);
		$this->display();
	}
	
	/**
	 * 移入历史档案
	 */
	public function toHistory($id=""){
		if(!per_check("project_edit")){
			$this->error("无此权限！");
		}
		$data = M("project")->where("bid_id='{$id}'")->find();
		if(M("project")->where("bid_id={$id}")->delete()){
			if(M("pro_record")->add($data)){
				$this->watchdog("转移", "将应标单《{$data['bid_subject']}》移入历史档案区");
				$this->success("移入成功！");
			}else{
				//数据回滚
				M("bidder")->add($data);
				$this->error("存入档案失败！");
			}
		}else{
			$this->error("移入失败！");
		}
	}
	
	/**
	 * 删除投标单
	 */
	public function delBid($id=""){
		if(!per_check("bidder_edit")){
			$this->error("无此权限！");
		}
		$map = array("bid_id"=>array("in", $id));
		$preDel = M("bidder")->field("bid_subject, bid_quoted, bid_tenders, bid_sn")->where($map)->select();
		foreach($preDel as $v){
			$names[] = $v['bid_subject'];
			$atts[] = $v['bid_quoted'];
			$atts[] = $v['bid_tenders'];
			$deposit[] = $v['bid_sn'];
		}
		if(M("bidder")->where($map)->delete()){
			//删除成功，删除附件，
			if(!empty($atts)){
				attDelete($atts);
			}
			if(!empty($deposit)){
				D("Deposit")->depositBack($deposit);
			}
			$this->watchdog("删除", "删除应标单《".implode("》，《", $names)."》");
			$this->success("删除成功！");
		
		}else{
			$this->error("删除失败！");
		}
	}
	
	public function delHistory($id=""){
		if(!per_check("bidder_edit")){
			$this->error("无此权限！");
		}
		$map = array("re_id"=>array("in", $id));
		$preDel = M("bid_record")->field("bid_subject, bid_quoted, bid_tenders, bid_sn")->where($map)->select();
		foreach($preDel as $v){
			$names[] = $v['bid_subject'];
			$atts[] = $v['bid_quoted'];
			$atts[] = $v['bid_tenders'];
			$deposit[] = $v['bid_sn'];
		}
		if(M("bid_record")->where($map)->delete()){
			//删除成功，删除附件，
			if(!empty($atts)){
				attDelete($atts);
			}
			if(!empty($deposit)){
				D("Deposit")->depositBack($deposit);
			}
			$this->watchdog("删除", "删除项目历史档案《".implode("》，《", $names)."》");
			$this->success("删除成功！");
		
		}else{
			$this->error("删除失败！");
		}
	}
}