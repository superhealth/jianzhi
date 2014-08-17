<?php
/**
 * 项目模块
 * @author dapianzi
 *
 */
class ProjectAction extends CommonAction{
	
	private $status = array(0=> "未发布", 1=> "招标中", 2=> "已开标", 3=>"关闭"); 	//项目状态
	private $limits = array(0=> "不限", 1=> "个人", 2=> "企业");	//项目投标限制
	/**
	 * 所有项目浏览
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
	 * 服务条款
	 *  
	 */
	public function serviceTerm(){
	  $this->display();
	}
	
	/**
	 * 发布项目
	 *  步骤1
	 */
	public function createStep1(){
		$this->display();
	}
	/**
	 * 发布项目
	 *  步骤2
	 */
	public function createStep2(){
		$this->checkMember();
		$this->display();
	}
	/**
	 * 发布项目
	 *  步骤3
	 */
	public function createStep3(){
		$this->checkMember();
		$type = $_POST['pro_type'];
		$enum = $_POST['pro_enum'];
		$sn = createProjectSn($_SESSION['member']);
		$this->display();
	}
	/**
	 * 发布项目
	 *  步骤4
	 */
	public function createStep4(){
		$this->checkMember();
		$this->display();
	}
	
	public function createEd(){
		$this->checkMember();
		if(M('project')->save($data)){
			$this->display()
		}else{
			$this->error('')
		}
		
	}
	
	/**
	 * 我的当前项目
	 */
	public function myProject($id=''){
		$this->checkMember();
		$info = M("project")->where('pro_id="'.$id.'" AND pro_mid="'.$_SESSION['member'].'"')->find();
		//项目状态
		$this->assign("status", array(0=> "未发布", 1=> "招标中", 2=> "已开标", 3=>"关闭"));
		//投标限制
		$this->assign("limits", array(0=> "不限", 1=> "个人", 2=> "企业"));
		
		$atts = D("Attachement")->getAtt($info['pro_attachement']);
		$this->assign("atts", $atts);
		// 应标单
		$bidders = D("Bidder")->getProBids($info['pro_id']);
		$this->assign("bidders", $bidders);
		$this->assign("info", $info);
		dump($info);
		dump($atts);
		dump($bidders);
		$this->display();
	}
	
	
	/**
	 * 修改项目
	 */
	public function modifyProject($id=""){
		$this->checkMember();
		$info = M('project')->join('zt_contact ON pro_contact=con_id')->where('pro_id="'.$id.'"')->find();
		$info['place'] = areaToSelect(areaDecode($info['pro_place']));
		$info['enums'] = enumsToSelect($info['pro_sort'], enumsDecode($info['pro_enums']));
		$atts = D('Attachement')->getAtt($info['pro_attachement']);
		$this->assign('atts', $atts);
		$this->assign('info', $info);
		//项目状态
		$this->assign("status", array(0=> "未发布", 1=> "招标中", 2=> "已开标", 3=>"关闭"));
		//投标限制
		$this->assign("limits", array(0=> "不限", 1=> "个人", 2=> "企业"));
		//所有主分类
		$sorts = D('Sort')->getSorts();
		$this->assign('sorts', $sorts);
		//所有属性
		$props = D('Property')->getProps();
		$this->assign('props', $props);
		// 应标单
		$bidders = D('Bidder')->getProBids($info['pro_id']);
		$this->assign('bidders', $bidders);
		$this->display();
	}
	
	/**
	 * 保存修改
	 */
	public function saveProject($id=""){
		$this->checkMember();
		$data = M('project')->create();
		
	}
	
	/**
	 * 取消项目
	 */
	public function cancleProject($id=""){
		$this->checkMember();
	}
	
	/**
	 * 移入历史档案区
	 */
	public function toHistory($id=""){
		$this->checkMember();
	}
	
	/**
	 * 草稿箱
	 */
	public function drafts(){
		$this->checkMember();
	}
}