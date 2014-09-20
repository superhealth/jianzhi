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
	 * 我的发布
	 * @see EmptyAction::index()
	 */
	public function index(){
		
		$this->display();
	}
	
	/**
	 * 所有项目浏览
	 */
	public function all(){
		$project = M("project");
		$map = array();
		//筛选条件
		$param = array();
		// 项目状态
		if(isset($_REQUEST['limitid']) && $_REQUEST['propid']!="all"){
			$map['pro_limit']  = $_REQUEST['limitid'];
			$param['limitid'] = $_REQUEST['limitid'];
		}
		// 项目属性
		if(isset($_REQUEST['propid']) && $_REQUEST['propid']!="all"){
			$map['pro_prop']  = $_REQUEST['propid'];
			$param['propid'] = $_REQUEST['propid'];
		}
		// 项目分类
		if(isset($_REQUEST['sortid']) && $_REQUEST['sortid']!="all"){
			$map['pro_sort']  = $_REQUEST['sortid'];
			$param['sortid'] = $_REQUEST['sortid'];
		}
		// 项目子类
		if(isset($_REQUEST['enums']) && $_REQUEST['enums']!=""){
			$map['pro_enums']  = array('like', "%{$_REQUEST['enums']}%");
			$param['enums'] = $_REQUEST['enums'];
			$queryEnums = explode('|', $_REQUEST['enums']);
			
			$this->assign('queryEnums', $queryEnums);
		}
		$memArea = array();
		$proArea = array();
		// 项目所在地
		if(isset($_REQUEST['pro_place']) && $_REQUEST['pro_place']!=""){
			$map['pro_place']  = array('like', '%'.$_REQUEST['pro_place'].'%');
			$param['pro_place'] = $_REQUEST['pro_place'];
			$proArea = areaDecode($_REQUEST['pro_place']);
		}
		// 公司所在地
		if(isset($_REQUEST['mem_place']) && $_REQUEST['mem_place']!=""){
			$map['pro_mid']  = array('in', D('Member')->getMemberInArea($_REQUEST['mem_place']));
			$param['mem_place'] = $_REQUEST['mem_place'];
			$memArea = areaDecode($_REQUEST['mem_place']);
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
		

		// 排序
		$order = "pro_publishtime DESC";
		if(isset($_REQUEST['order'])){
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? 'ASC' : 'DESC';
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = 'DESC';
			}
			switch($_REQUEST['order']){
				case 'publish':
					$order = "pro_publishtime ".$asc;
					break;
				case 'open':
					$order = "pro_opentime ".$asc;
					break;
				case 'bids':
					$order = "bidders ".$asc;
					break;
				default: 
					$order = "pro_publishtime DESC";
			}
			$param['order'] = $_REQUEST['order'];
		}else{
			$order = "pro_publishtime DESC";
		}
		
		// 分页
		$total = $project->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				"(SELECT bid_proid,count(*) bidders FROM zt_bidder GROUP BY bid_proid) b ON pro_id=b.bid_proid"
		);
		// 查询字段
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_sort, pro_prop, pro_publishtime, pro_limit, pro_place, pro_opentime, pro_startstop, pro_status, IFNULL(bidders, 0) bidders";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		foreach ($projects as &$v){
			$starstop = explode("-", $v['pro_startstop']);
			$v['pro_endtime'] = mb_substr($starstop[1], 0, strpos($starstop[1], '日')+1, 'utf-8');
			$v['pro_place']	= str_replace(array('|','中国','省','市'),array('','',' ',''), $v['pro_place']);
			$v['mem_place'] = D('Member')->getMemberPlace($v['pro_mid']);
			$v['mem_place'] = str_replace(array('|','中国','省','市'),array(' ','',' ',''), $v['mem_place']);
		}
		
		// 项目状态
		$this->assign("status", $this->status);
		$this->assign("projects", $projects);
		// 类别
		$sorts = D('Sort')->getSorts();
		$this->assign('sorts', $sorts);
		// 子类
		$enums = D('Enumsort')->enums();
		$this->assign('enums', $enums);
		// 所有属性
		$props = D("Property")->getProps();
		$this->assign("props", $props);
		// 用户投标限制
		$this->assign("limits", $this->limits);
		// 地区
		
		$this->assign('pro_place', areaToSelect($proArea, 1, "", "pro_place"));
		$this->assign('mem_place', areaToSelect($memArea, 1, "", "mem_place"));
		$this->display();
	}
	/**
	 * 项目详情
	 * @param string $id
	 */
	public function detail($id=""){
		if(empty($id)){
			$this->_empty();
		}else{
			$join = array(
				'zt_sort ON pro_sort=sort_id',
				'zt_property ON pro_prop=pp_id',
				'zt_contact ON pro_contact=con_id'
			);
			$info = M("project")->join($join)->where("pro_id='{$id}'")->find();
			if(empty($info)){
				$this->_empty();
			}
			if($info['pro_mid']==$_SESSION['member']){
				redirect(__URL__.'/myProject/id/'.$id);exit;
			}
			//项目所在地
			$info['pro_place'] = str_replace(array('中国','|','市','省'), array(' ',' ',' ',' '), $info['pro_place']);
			//项目分类
			$info['sorts'] = enumsDecode($info['pro_enums']);
			array_unshift($info['sorts'], $info['sort_name']);
			$info['sorts'] = implode(' / ', $info['sorts']);
			//项目开标剩余时间
			
			$info['openLeft'] = getTimeLeft($info['pro_opentime']);
			//项目附件
			$info['atts'] = D("Attachement")->getAtt($info['pro_attachement']);
			//应标数量
			$info['bids'] = D("Bidder")->getProBidersCount($info['pro_id']);
			//项目信息
			$this->assign("proInfo", $info);
			//项目发布者信息
			$member = M("member")->where("mem_id='{$info['pro_mid']}'")->find();
			$member['regdays'] = getTimePass($member['mem_regtime'], 'd');
			if($member['mem_type']==0){
				$memberinfo = M("memberperson")->where("mp_mid='{$info['pro_mid']}'")->find();
				$member['place'] = str_replace(array('中国','|','市','省'), array(' ',' ',' ',' '), $memberinfo['mp_addr']);
				$member['status'] = $memberinfo['mp_status'];
			}else{
				$memberinfo = M("membercompany")->where("mc_mid='{$info['pro_mid']}'")->find();
				$member['place'] = str_replace(array('中国','|','市','省'), array(' ',' ',' ',' '), $memberinfo['mc_addr']);
				$member['status'] = $memberinfo['mc_status'];
			}
			$member['pros'] = D('Project')->getBidersCount($member['mem_id']);
			$this->assign('memInfo', $member);
			//项目状态
			$this->assign("status", $this->status);
			//投标限制
			$this->assign("limits", $this->limits);
			//项目收藏状态
			$isCollect = D('Collection')->isCollected($id, $_SESSION['member']);
			$this->assign('collected', $isCollect);
			//项目浏览+1
			D('Project')->browser($id);
			$this->display();
		}
	}
	/**
	 * 收藏项目
	 * @param int $id
	 */
	public function proCollect($id){
		$ajaxData = array('code'=>0, 'data'=>'');
		if(empty($_SESSION['member'])){
			$ajaxData['code'] = 100;
			$ajaxData['data'] = __GROUP__."/Member/login/flag/true";
		}else{
			if(D('Collection')->addCollection($id, $_SESSION['member'])){
				$ajaxData['data'] = '取消收藏';
				$ajaxData['id'] 		= D('Collection')->getLastInsID();
				$ajaxData['url'] 	= __URL__.'/cancelCollect';
				$ajaxData['code'] = 1;
			}else{
				$ajaxData['data'] = '添加收藏失败！'.D('Collection')->getError();
			}
		}
		echo json_encode_nonull($ajaxData);exit;
	}
	/**
	 * 取消收藏
	 * @param int $id
	 */
	public function cancelCollect($id){
		$ajaxData = array('code'=>0, 'data'=>'');
		if(empty($_SESSION['member'])){
			$ajaxData['code'] = 100;
			$ajaxData['data'] = __GROUP__."/Member/login/flag/true";
		}else{
			$pid = M('Collection')->where("co_id={$id}")->getField('co_proid');
			if(D('Collection')->cancelCollection($id, $_SESSION['member'])){
				$ajaxData['data'] = '添加收藏';
				$ajaxData['id'] 		= $pid;
				$ajaxData['url']	= __URL__.'/proCollect';
				$ajaxData['code'] = 1;
			}else{
				$ajaxData['data'] = '取消收藏失败！请稍后再试~';
			}
		}
		echo json_encode_nonull($ajaxData);exit;
	}
	
	/**
	 * 下载项目附件
	 * @param number $id
	 * @param number $aid
	 */
	public function attachDownload($id=0, $aid=0){
		$this->checkMember();
		if(empty($id)||empty($aid)){
			$this->error('Sorry~ 您所下载文件不存在！');
		}else{
			$proInfo = M('project')->field('pro_limit, pro_attachement')->where("pro_id={$id}")->find();
			$atts = explode(',', $proInfo['pro_attachement']);
			if(in_array($aid, $atts)){
				$mem_type = M('member')->where('mem_id="'.$_SESSION['member'].'"')->getField('mem_type');
				// 检查对用户的下载限制
				if($proInfo['pro_limit'] == $mem_type+1 || $proInfo['pro_limit']==0){
					$att = new AttachAction();
					$att->download($aid);
				}else{
					$this->error('对不起，该文件限制为 <strong>'.$this->limits[$proInfo['pro_limit']].'</strong> 用户才能下载');
				}
			}else{
				$this->error('Sorry~ 您所下载文件不存在！');
			}
		}
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
		//类别
		$sorts = D('Sort')->getSorts();
		$this->assign('sorts', $sorts);
		//子类
		$enums = D('Enumsort')->enums();
		$this->assign('enums', $enums);
		$this->display();
	}
	
	/**
	 * 保存分类
	 */
	public function createSort(){
		$this->checkMember();
		if(empty($_POST['pro_type'])){
			$this->error('请选择类别！', __URL__.'/createStep2', 2);
		}
		$data = array(
				'pro_sort'	=> $_POST['pro_type'],
				'pro_enums'=> str_replace(',', '|', $_POST['pro_enum']),
				'pro_sn'		=> createProjectSn($_SESSION['member']),
				'pro_mid'	=> $_SESSION['member'],
				'pro_step'	=> 3
		);
		if(M('project')->add($data)){
			$pro_id = M('project')->getLastInsID();
			cookie('newProject', $pro_id, time()+3600*24);
			$_SESSION['newProject'] = $pro_id;
		}
		redirect(__URL__.'/createStep3');
	}
	/**
	 * 发布项目
	 *  步骤3
	 */
	public function createStep3(){
		$this->checkMember();
		if(!empty($_SESSION['newProject'])){
			$id = $_SESSION['newProject'];
			unset($_SESSION['newProject']);
		}else if(!empty($_COOKIE['newProject'])){
			$id = $_COOKIE['newProject'];
		}else{
			redirect(__URL__.'/createStep2');
		}
		$newProjectInfo = M('project')->join('zt_sort ON pro_sort=sort_id')->where('pro_id="'.$id.'"')->find();
		$newProjectInfo['attachs'] = D('Attachement')->getAtt($newProjectInfo['pro_attachement']);
		$newProjectInfo['pro_enum'] = enumsDecode($newProjectInfo['pro_enums']);
		$newProjectInfo['place'] = areaToSelect(array());
		$newProjectInfo['startToEnd'] = explode('-', $newProjectInfo['pro_startstop']);
		$newProjectInfo['cover'] = D('Attachement')->getAttSrc($newProjectInfo['pro_cover']);
		$this->assign('newProject', $newProjectInfo);
		$this->display();
	}
	
	/**
	 * 保存项目资料 项目信息
	 */
	public function createInfo1(){
		$this->checkMember();
		$data = M("project")->create();
		$data['pro_opentime'] = cnStrToTime($data['pro_opentime']);
		$data['pro_startstop'] = $_POST['pro_start'].'-'.$_POST['pro_end'];
		$data['pro_place'] = areaEncode($_POST['area']);
		$data['pro_step'] = 4;
		$map = array('pro_mid'=> $_SESSION['member'], 'pro_id'=> $_POST['id']);
		if(M("project")->where($map)->save($data)){
			cookie('newProject', $_POST['id'], time()+3600*24);
			$_SESSION['newProject'] = $_POST['id'];
			redirect(__URL__.'/createStep4');
		}
		else{
			$this->error('出错了~保存项目信息失败！' );
		}
	}
	
	/**
	 * 发布项目
	 *  步骤4
	 */
	public function createStep4(){
		$this->checkMember();
		if(!empty($_SESSION['newProject'])){
			$id = $_SESSION['newProject'];
			unset($_SESSION['newProject']);
		}
		else if(!empty($_COOKIE['newProject'])){
			$id = $_COOKIE['newProject'];
		}
		else{
			redirect(__URL__.'/createStep2');
		}
		$field = 'pro_id, pro_prop, pro_limit, pro_addition, pro_contact, con_id, con_name, con_email, con_tel,  con_im';
		$newProjectInfo = M('project')->join('zt_contact ON pro_contact=con_id')->field($field)->where('pro_id="'.$id.'"')->find();
		// 联系人为空，查找用户默认联系方式
		if(empty($newProjectInfo['con_id'])){
			$memberInfo = M('member')->where('mem_id="'.$_SESSION['member'].'"')->find();
			// 用户邮箱
			$newProjectInfo['con_email'] = $memberInfo['mem_email'];
			// 通过验证
			if($memberInfo['mem_state'] > 0){
				// 企业用户
				if($memberInfo['mem_type'] > 0){
					$mcInfo = M('membercompany')->where('mc_mid="'.$_SESSION['member'].'"')->find();
					$newProjectInfo['con_tel'] = $mcInfo['mc_tel'];
					$newProjectInfo['con_name'] = $mcInfo['mc_legal'];
					unset($mcInfo);
				}
				// 个人用户
				else{
					$mpInfo = M('memberperson')->where('mp_mid="'.$_SESSION['member'].'"')->find();
					$newProjectInfo['con_tel'] = $mpInfo['mp_tel'];
					$newProjectInfo['con_name'] = $mpInfo['mp_name'];
				}
			}
			unset($memberInfo);
		}
		$this->assign('props', D('Property')->getProps());
		$this->assign('limits', $this->limits);
		$this->assign('newProject', $newProjectInfo);
		$this->display();
	}
	
	/**
	 * 保存项目资料 对投标要求
	 */
	public function createInfo2(){
		$this->checkMember();
		
		// 当前用户和项目ID
		$where = array('pro_mid'=>$_SESSION['member'], 'pro_id'=>$_POST['id']);
		//保存联系人
		$con_data = M('contact')->create();
		$con_id = M('project')->where($where)->getField('pro_contact');
		if(empty($con_data['con_id'])){
			$con_id = M('contact')->add($con_data);
			M('project')->where($where)->setField('pro_contact', $con_id);
		}else{
			M('contact')->where('con_id='.$con_id)->save($con_data);
		}
		$data = M('project')->create();
		$data['pro_status'] = 1;	//项目状态已发布
		$data['pro_publishtime'] = $_SERVER['REQUEST_TIME'];
		if(M('project')->where($where)->save($data)){
			$_SESSION['newProject'] = $_POST['id'];
			redirect(__URL__.'/createEd');
		}
		else{
			$this->error('保存失败！请稍后再试或联系我们的客服');
		}
	}
	
	public function createEd(){
		$this->checkMember();
		if(!empty($_SESSION['newProject'])){
			$id = $_SESSION['newProject'];
		}
		else{
			redirect(__URL__.'/createStep2');
		}
		$field = 'pro_id, pro_sn, pro_subject, pro_mid, pro_prop, pro_limit, pro_quantity, pro_unit, sort_name, pro_enums, pro_publishtime, pro_updatetime,  pro_opentime, pro_step, pro_status';
		$newProjectInfo = M('project')->field($field)->join('`zt_sort` ON `zt_sort`.`sort_id`=`zt_project`.`pro_sort`')->where('pro_id="'.$id.'"')->find();
		// 未发布项目 项目草稿
		if($newProjectInfo['pro_status']<1){
			redirect(__URL__.'/createStep'.$newProjectInfo['pro_step']);exit;
		}
		$this->assign('props', D('Property')->getProps());
		$this->assign('limits', $this->limits);
		$this->assign('newProject', $newProjectInfo);
		unset($_SESSION['newProject']);
		$this->display();	
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
		$step = 0;
	}
}