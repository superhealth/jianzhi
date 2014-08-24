<?php
/**
 * 投标模块
 * @author Carl
 *
 */
class BidAction extends CommonAction{
	/**
	 * 投标中心，已投项目总览
	 * 
	 */
	public function index(){
		$project = M("project");
		$map = array();
		//筛选条件
		$param = array();
		//项目状态
		if(isset($_REQUEST['status']) && $_REQUEST['status']!="all"){
			$map['pro_status']  = $_REQUEST['status'];
			$param['status'] = $_REQUEST['status'];
		}
		//项目属性
		if(isset($_REQUEST['prop']) && $_REQUEST['prop']!="all"){
			$map['pro_prop']  = $_REQUEST['prop'];
			$param['prop'] = $_REQUEST['prop'];
		}
		//项目分类
		if(isset($_REQUEST['sort']) && $_REQUEST['sort']!="all"){
			$map['pro_sort']  = $_REQUEST['sort'];
			$param['sort'] = $_REQUEST['sort'];
		}
		// 项目主题 or 发布作者
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
		//起止时间
		
		//按详细分类查询
		
		
		$this->assign("param", $param);
		// 分页
		$total = $project->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				"(SELECT bid_proid,count(*) bidders FROM zt_bidder GROUP BY bid_proid) b ON pro_id=b.bid_proid",
		);
		// 查询字段
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_sort, pro_prop, pro_publishtime, pro_status, IFNULL(bidders, 0) bidders";
		// 排序
		$order = "pro_publishtime DESC";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		// 项目状态
		$this->assign("status", $this->status);
		$this->assign("projects", $projects);
		//所有分类
		$sorts = D("Sort")->getSorts();
		$this->assign("sorts", $sorts);
		//所有属性
		$props = D("Property")->getProps();
		$this->assign("props", $props);
		$this->display();
	}
	
	/**
	 * 新建应标
	 * @param 创建步骤1
	 */
	public function createStep1(){
		$this->checkMember();
	}
	/**
	 * 新建应标
	 * @param 创建步骤2
	 */
	public function createStep2(){
		$this->checkMember();
	}
	/**
	 * 新建应标
	 * @param 创建步骤3
	 */
	public function createStep3(){
		$this->checkMember();
	}
	
	
	
	/**
	 * 查看投标信息
	 * @param string $sn 投标序列号
	 */
	public function viewBidder($sn=""){
		
	}
	
	/**
	 * 修改投标信息
	 */
	public function modifyBidder(){
		$this->checkMember();
	}
	/**
	 * 取消投标信息
	 */
	public function cancleBidder(){
		$this->checkMember();
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory(){
		$this->checkMember();
	}
	
	/**
	 * 草稿箱
	 */
	public function drafts(){
		$this->checkMember();
	}
	
}