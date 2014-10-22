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
	 * 我发布的项目/ 我的发单
	 * 
	 */
	public function index(){
		$this->checkMember();
		$this->leftInit();
		$project = M('Project');
		$map = array(
				'pro_status'=> array('in', '1,2'),				// 已发布
				'pro_mid'	=> $_SESSION['member']		// 
		);
		$param = array('status'=> 'all');
		// 匹配开标条件
		if( isset($_REQUEST['status'])){
			if($_REQUEST['status']!='all'){
				$map['pro_status']	= $_REQUEST['status'];
			}
			$param['status'] = $_REQUEST['status'];
		}
		// 查询
		if( isset($_REQUEST['words']) && strlen($_REQUEST['words'] )>2){
			$filter = addslashes($_REQUEST['words']);
			$map['_complex'] = array(
				'pro_subject'	=> array('like', '%'.$filter.'%'),
				'pro_sn'				=> array('like', '%'.$filter.'%'),
				'_logic'				=> 'or'
			);
			$param['words'] = $_REQUEST['words'];
		}

		$order = "pro_publishtime DESC";	//默认排序
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
		$page = new Page($total, 8, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				" LEFT JOIN (SELECT bid_proid,count(*) bidders FROM zt_bidder GROUP BY bid_proid) b ON pro_id=b.bid_proid ",
				' LEFT JOIN zt_sort ON pro_sort=sort_id',
				' LEFT JOIN zt_property ON pro_prop=pp_id'
		);
		// 查询字段
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, sort_name, pro_enums, pp_name, pro_publishtime, pro_opentime, pro_status, IFNULL(bidders, 0) bidders";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		foreach ($projects as &$v){
			if($v['pro_opentime']>time()){
				$v['opentime']	= date('Y/m/d H:i', $v['pro_opentime']);
			}else{
				$v['opentime']	= '<span class="red">已开标</span>';
			}
		}
		// 项目状态
		$this->assign("status", $this->status);
		// 用户投标限制
		$this->assign("limits", $this->limits);
		$this->assign("projects", $projects);
		$this->display();

	}
	
	/**
	 * 所有项目浏览
	 */
	public function all(){
		$project = M("project");
				$map = array(
				'pro_status'	=> array('in', '1,2')	// 查找已发布且未关闭的项目
			);
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
			
			$map['pro_place']  = array('like', '%'.str_replace('no','',$_REQUEST['pro_place']).'%');
			$param['pro_place'] = $_REQUEST['pro_place'];
			$proArea = areaDecode($_REQUEST['pro_place']);
		}
		// 公司所在地
		if(isset($_REQUEST['mem_place']) && $_REQUEST['mem_place']!=""){
			$map['pro_mid']  = array('in', D('Member')->getMemberInArea(str_replace('no','',$_REQUEST['mem_place'])));
			$param['mem_place'] = $_REQUEST['mem_place'];
			$memArea = areaDecode($_REQUEST['mem_place']);
		}
		// 项目主题 or 发布作者 or 项目编号
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			//大于3个字符
			if(strlen($words)>2){
				$where['pro_subject']  = array('like', "%{$words}%");
				$where['pro_mid'] = array('like', "%{$words}%");
				$where['pro_sn'] = array('like', "%{$words}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		
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
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_sort, pro_enums, pro_prop, pro_publishtime, pro_limit, pro_place, pro_opentime, pro_startstop, pro_status, IFNULL(bidders, 0) bidders";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		// 项目状态
		$this->assign("status", $this->status);
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
		foreach ($projects as &$v){
			$starstop = explode("-", $v['pro_startstop']);
			$v['pro_endtime'] = mb_substr($starstop[1], 0, strpos($starstop[1], '日')+1, 'utf-8');
			$v['pro_place']	= str_replace(array('|','中国','省','市'),array('','',' ',' '), $v['pro_place']);
			$v['mem_place'] = D('Member')->getMemberPlace($v['pro_mid']);
			$v['mem_place'] = str_replace(array('|','中国','省','市'),array(' ','',' ',' '), $v['mem_place']);
			$v['sorts'] = enumsDecode($v['pro_enums']);
			array_unshift($sorts[$v['pro_sort']], $v['sort_name']);
			$v['sorts'] = implode(' / ', $v['sorts']);
		}
		$this->assign("projects", $projects);
		
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
			if($info['pro_status']>2){
				$this->error('Sorry~该项目已被取消！');
			}
			//项目封面
			$info['cover'] = D('Attachement')->getAttSrc($info['pro_cover']);
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
				'pro_sort'				=> $_POST['pro_type'],
				'pro_enums'			=> str_replace(',', '|', $_POST['pro_enum']),
				'pro_sn'					=> createProjectSn($_SESSION['member']),
				'pro_mid'				=> $_SESSION['member'],
				'pro_step'				=> 3,
				'pro_createtime'	=> $_SERVER['REQUEST_TIME']
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
		if(0==$newProjectInfo['pro_opentime']){
			$newProjectInfo['pro_opentime'] = '';
		}
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
		if(empty($data['pro_subject'])){
			$this->error('Sorry~ 项目标题不能为空！');
		}
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
	
	/**
	 * 创建项目成功
	 */
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
		$this->display();	
	}
	
	/**
	 * 我发布的项目 详情
	 * @param string $id
	 */
	public function myProject($id=""){
		if(empty($id)){
			$this->_empty();
		}else{
			$join = array(
					'zt_sort ON pro_sort=sort_id',
					'zt_property ON pro_prop=pp_id',
					'zt_contact ON pro_contact=con_id'
			);
			$info = M("project")->join($join)->where("pro_id='{$id}' AND pro_mid='{$_SESSION['member']}'")->find();
			if(empty($info)){
				$this->_empty();
			}
			//项目封面
			$info['cover'] = D('Attachement')->getAttSrc($info['pro_cover']);
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
			$this->display();
		}
	}
	
	/**
	 * 修改项目
	 * 条件：本人发布的项目且未开标
	 */
	public function modify($id=""){
		$this->checkMember();
		$where = array(
				'pro_id'	=> $id,
				'pro_mid'	=> $_SESSION['member'],
				'pro_status'	=> 1
		);
		$info = M('project')->join('zt_contact ON pro_contact=con_id')->where($where)->find();
		if(empty($info)){
			$this->error('Sorry~项目已开标或不存在！');
		}
		if($info['pro_opentime']<($_SERVER['REQUEST_TIME']-PROTECT_TIME)){
			$this->error('Sorry~该项目即将开标，无法修改！');
		}
		$info['place'] = areaToSelect(areaDecode($info['pro_place']));
		$info['cover'] = D('Attachement')->getAttSrc($info['pro_cover']);
		$info['attachs'] = D('Attachement')->getAtt($info['pro_attachement']);
		$info['startToEnd'] = explode('-', $info['pro_startstop']);
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
		$this->display();
	}
	
	/**
	 * 保存修改
	 */
	public function save(){
		$this->checkMember();
		// 当前用户和项目ID
		$where = array('pro_mid'=>$_SESSION['member'], 'pro_id'=>$_POST['pro_id']);
		//保存联系人
		$con_data = M('contact')->create();
		$proInfo = M('project')->field('pro_opentime, pro_contact')->where($where)->find();
		if(empty($proInfo)){
			$this->error('Sorry~该项目不存在！');
		}
		if($proInfo['pro_opentime']<($_SERVER['REQUEST_TIME']-PROTECT_TIME)){
			$this->error('Sorry~该项目即将开标或已开标，无法修改！');
		}
		if(empty($proInfo['pro_contact'])){
			$con_id = M('contact')->add($con_data);
			M('project')->where($where)->setField('pro_contact', $con_id);
		}else{
			M('contact')->where('con_id='.$proInfo['pro_contact'])->save($con_data);
		}
		$data = M('project')->create();
		$data['pro_opentime'] = cnStrToTime($data['pro_opentime']);
		$data['pro_startstop'] = $_POST['pro_start'].'-'.$_POST['pro_end'];
		$data['pro_place'] = areaEncode($_POST['area']);
		$data['pro_updatetime'] = $_SERVER['REQUEST_TIME'];
		if(M('project')->where($where)->save($data)){
			$_SESSION['modifyId'] = $_POST['pro_id'];
			redirect(__URL__.'/saved');
		}else{
			$this->error('修改失败！没有任何变化');
		}
	}
	
	public function saved(){
		$this->checkMember();
		if(empty($_SESSION['modifyId'])){
			$this->_empty();
		}
		$field = 'pro_id, pro_sn, pro_subject, pro_mid, pro_prop, pro_limit, pro_quantity, pro_unit, sort_name, pro_enums, pro_publishtime, pro_updatetime,  pro_opentime, pro_step, pro_status';
		$newProjectInfo = M('project')->field($field)->join('`zt_sort` ON `zt_sort`.`sort_id`=`zt_project`.`pro_sort`')->where('pro_id="'.$_SESSION['modifyId'].'"')->find();
		$this->assign('props', D('Property')->getProps());
		$this->assign('limits', $this->limits);
		$this->assign('proInfo', $newProjectInfo);
		$this->display();	
	}
	
	/**
	 * 取消项目
	 * 条件：本人发布的项目， 已发布且未开标项目
	 */
	public function delete($id=""){
		$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'pro_id'		=> $id,
				'pro_mid'	=> $_SESSION['member'],
				'pro_status'	=> array('lt', 2)
		);
		$proInfo = M('project')->field('pro_id, pro_subject, pro_opentime')->where($where)->find();
		if(!empty($proInfo)){
			if($proInfo['pro_opentime']<($_SERVER['REQUEST_TIME']-PROTECT_TIME)){
				//设置项目状态
				M('project')->where($where)->setField('pro_status', 4);
				// 所收到的投标自动转为历史
				M('bidder')->where('bid_proid='.$id)->setField('bid_state', 2);
				//向投标用户发送消息
				$bids	= M('bidder')->where('bid_proid='.$id)->getField('bid_mid', true);
				foreach($bids as $v){
					$subject = '招标取消通知';
					$content = '很遗憾，您所投标的项目《'.$proInfo['pro_subject'].'》已被发布者取消。';
					D('Notice')->sendProNotice($v, $subject, $content);
				}
				$this->ajaxReturn($response);
			}else{
				$response['code'] 	= 2;
				$response['data']	= 'Sorry~ 该项目即将开标，不能删除！';
				$this->ajaxReturn($response);
			}
		}else{
			$response['code'] 	= 1;
			$response['data']	= 'Sorry~项目已开标或不存在！';
			$this->ajaxReturn($response);
		}
	}
	
	
	/**
	 * 草稿箱
	 */
	public function drafts(){
		$this->checkMember();
		$this->leftInit();
		$project = M('Project');
		$map = array(
				'pro_status'	=> 0,
				'pro_mid'		=> $_SESSION['member']
			);
		// 查询
		if( isset($_REQUEST['words']) && strlen($_REQUEST['words'] )>2){
			$filter = addslashes($_REQUEST['words']);
			$map['_complex'] = array(
				'pro_subject'	=> array('like', '%'.$filter.'%'),
				'pro_sn'				=> array('like', '%'.$filter.'%'),
				'_logic'				=> 'or'
			);
			$paramp['words'] = $_REQUEST['words'];
		}

		$order = "pro_publishtime DESC";	//默认排序
		if(isset($_REQUEST['order'])){
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? 'ASC' : 'DESC';
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = 'DESC';
			}
			switch($_REQUEST['order']){
				case 'create':
					$order = "pro_createtime ".$asc;
					break;
				default:
					$order = "pro_createtime DESC";
			}
			$param['order'] = $_REQUEST['order'];
		}else{
			$order = "pro_createtime DESC";
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

		// 查询字段
		$field = "pro_id, pro_sn, pro_subject, pro_createtime";
		$projects = $project->field($field)->where($map)->order($order)->limit($limit)->select();
		$this->assign("projects", $projects);
		$this->display();
	}
	
	/**
	 * 修改、发出草稿项目
	 * 
	 */
	public function draftEdit(){
		$this->checkMember();
		$where = array(
				'pro_id'		=> $_REQUEST['id'],
				'pro_mid'	=> $_SESSION['member'],
				'pro_status'	=> 0
		);
		$info = M('project')->join('zt_contact ON pro_contact=con_id')->where($where)->find();
		if(empty($info)){
			$this->error('Sorry~项目不存在！');
		}
		$info['place'] = areaToSelect(areaDecode($info['pro_place']));
		$info['cover'] = D('Attachement')->getAttSrc($info['pro_cover']);
		$info['attachs'] = D('Attachement')->getAtt($info['pro_attachement']);
		$info['startToEnd'] = explode('-', $info['pro_startstop']);
		// 联系人为空，查找用户默认联系方式
		if(empty($info['con_id'])){
			$memberInfo = M('member')->where('mem_id="'.$_SESSION['member'].'"')->find();
			// 用户邮箱
			$info['con_email'] = $memberInfo['mem_email'];
			// 通过验证
			if($memberInfo['mem_state'] > 0){
				// 企业用户
				if($memberInfo['mem_type'] > 0){
					$mcInfo = M('membercompany')->where('mc_mid="'.$_SESSION['member'].'"')->find();
					$info['con_tel'] = $mcInfo['mc_tel'];
					$info['con_name'] = $mcInfo['mc_legal'];
					unset($mcInfo);
				}
				// 个人用户
				else{
					$mpInfo = M('memberperson')->where('mp_mid="'.$_SESSION['member'].'"')->find();
					$info['con_tel'] = $mpInfo['mp_tel'];
					$info['con_name'] = $mpInfo['mp_name'];
				}
			}
			unset($memberInfo);
		}
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
		$this->display();
	}
	/**
	 * 保存修改
	 */
	public function saveDraft(){
		$this->checkMember();
		// 当前用户和项目ID
		$where = array('pro_mid'=>$_SESSION['member'], 'pro_id'=>$_POST['pro_id']);
		//保存联系人
		$con_data = M('contact')->create();
		$proInfo = M('project')->field('pro_opentime, pro_contact')->where($where)->find();
		if(empty($proInfo)){
			$this->error('Sorry~该项目不存在！');
		}
		if(empty($proInfo['pro_contact'])){
			$con_id = M('contact')->add($con_data);
			M('project')->where($where)->setField('pro_contact', $con_id);
		}else{
			M('contact')->where('con_id='.$proInfo['pro_contact'])->save($con_data);
		}
		$data = M('project')->create();
		$data['pro_opentime'] = cnStrToTime($data['pro_opentime']);
		$data['pro_startstop'] = $_POST['pro_start'].'-'.$_POST['pro_end'];
		$data['pro_place'] = areaEncode($_POST['area']);
		if(M('project')->where($where)->save($data)){
			$this->success('保存成功！', __URL__.'/drafts');
		}else{
			$this->error('修改失败！没有任何变化');
		}
	}
	/**
	 * 发出项目
	 */
	public function launchDraft(){
		$this->checkMember();
		// 当前用户和项目ID
		$where = array('pro_mid'=>$_SESSION['member'], 'pro_id'=>$_POST['pro_id']);
		//保存联系人
		$con_data = M('contact')->create();
		$proInfo = M('project')->field('pro_opentime, pro_contact')->where($where)->find();
		if(empty($proInfo)){
			$this->error('Sorry~该项目不存在！');
		}
		if(empty($proInfo['pro_contact'])){
			$con_id = M('contact')->add($con_data);
			M('project')->where($where)->setField('pro_contact', $con_id);
		}else{
			M('contact')->where('con_id='.$proInfo['pro_contact'])->save($con_data);
		}
		$data = M('project')->create();
		$data['pro_opentime']	= cnStrToTime($data['pro_opentime']);
		$data['pro_startstop']	= $_POST['pro_start'].'-'.$_POST['pro_end'];
		$data['pro_place']			= areaEncode($_POST['area']);
		$data['pro_status']			= 1;
		$data['pro_publishtime'] = $_SERVER['REQUEST_TIME'];
		if(M('project')->where($where)->save($data)){
			$_SESSION['newProject'] = $_POST['pro_id'];
			redirect(__URL__.'/createEd');
		}else{
			$this->error('项目发布失败！');
		}
	}
	
	/**
	 * 删除草稿
	 */
	public function draftDel(){
		$this->checkMember();
		$id = $_REQUEST['id'];
		$response = array('code'=>0, 'data'=>'');
		if(empty($id)){
			$this->error('未选择草稿！');
		}
		$where = array(
				'pro_id'		=> array('in', $id),
				'pro_mid'	=> $_SESSION['member'],
				'pro_status'	=> 0
		);
		if(M('project')->where($where)->delete()){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}
	
	/**
	 * 移入历史档案区 关闭项目
	 */
	public function toHistory($id=""){
		$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'pro_id'		=> $id,
				'pro_mid'	=> $_SESSION['member']
		);
		$is_exist = M('project')->where($where)->count();
		if($is_exist>0){
			$proInfo = M('project')->field('pro_id, pro_subject, pro_opentime')->where($where)->find();
			if($proInfo['pro_opentime']<$_SERVER['REQUEST_TIME']){
				//设置项目状态
				M('project')->where($where)->setField('pro_status', 3);
				// 所收到的投标自动转为历史
				M('bidder')->where('bid_proid='.$id)->setField('bid_state', 2);
				//向投标用户发送消息
				$bids	= M('bidder')->where('bid_proid='.$id)->getField('bid_mid');
				foreach($bids as $v){
					$subject = '招标结束通知';
					$content = '您所投标的项目《'.$proInfo['pro_subject'].'》已被发布者关闭。';
					D('Notice')->sendProNotice($v, $subject, $content);
				}
				$this->ajaxReturn($response);
			}else{
				$response['code'] 	= 2;
				$response['data']	= 'Sorry~该项目还未开标，不能关闭！';
				$this->ajaxReturn($response);
			}
		}else{
			$response['code'] 	= 1;
			$response['data']	= '项目未开标或不存在！';
			$this->ajaxReturn($response);
		}
	}

	/**
	 * 删除历史档案项目
	 */
	public function delHistory($id=""){
		$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'pro_id'		=> $id,
				'pro_mid'	=> $_SESSION['member'],
				'pro_status'	=> 3,
		);
		if(M('bidder')->where($where)->setField('pro_status', 4)){
		}else{
			$response['code'] 	= 1;
			$response['data']	= 'Sorry~档案项目不存在！';
		}
		$this->ajaxReturn($response);
	}
	/**
	 * 历史档案
	 */
	public function history(){
		$this->checkMember();
		$this->leftInit();
		$project = M('Project');
		$map = array(
				'pro_status'=> 3,				// 已关闭
				'pro_mid'	=> $_SESSION['member']	
		);
		$param = array();
		// 查询
		if( isset($_REQUEST['words']) && strlen($_REQUEST['words'] )>2){
		$filter = addslashes($_REQUEST['words']);
		$map['_complex'] = array(
				'pro_subject'	=> array('like', '%'.$filter.'%'),
				'pro_sn'				=> array('like', '%'.$filter.'%'),
				'_logic'				=> 'or'
		);
		$param['words'] = $_REQUEST['words'];
		}

		$order = "pro_publishtime DESC";	//默认排序
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
		$page = new Page($total, 8, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				" LEFT JOIN (SELECT bid_proid,count(*) bidders FROM zt_bidder GROUP BY bid_proid) b ON pro_id=b.bid_proid ",
				' LEFT JOIN zt_sort ON pro_sort=sort_id',
				' LEFT JOIN zt_property ON pro_prop=pp_id'
		);
		// 查询字段
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, sort_name, pro_enums, pp_name, pro_publishtime, pro_opentime, pro_status, IFNULL(bidders, 0) bidders";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		foreach ($projects as &$v){
			if($v['pro_opentime']>time()){
				$v['opentime']	= date('Y/m/d H:i', $v['pro_opentime']);
			}else{
				$v['opentime']	= '<span class="red">已开标</span>';
			}
		}
		// 项目状态
		$this->assign("status", $this->status);
		// 用户投标限制
		$this->assign("limits", $this->limits);
		$this->assign("projects", $projects);
		$this->display();
		
	}
	
	public function viewHistory($id=0){
		if(empty($id)){
			$this->_empty();
		}else{
			$join = array(
					'zt_sort ON pro_sort=sort_id',
					'zt_property ON pro_prop=pp_id',
					'zt_contact ON pro_contact=con_id'
			);
			$info = M("project")->join($join)->where("pro_id='{$id}' AND pro_mid='{$_SESSION['member']}'")->find();
			if(empty($info)){
				$this->_empty();
			}
			//项目封面
			$info['cover'] = D('Attachement')->getAttSrc($info['pro_cover']);
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
			$this->display();
		}
	}
	
	/**
	 * 收到的应标
	 */
	public function receiveBids(){
		$this->checkMember();
		$this->leftInit();
		if(!isset($_REQUEST['tag'])){
			$this->assign('searchError', '请选择上方查询条件！');
			$param['tag'] = 'pro';
		}else{
			$param['tag'] = $_REQUEST['tag'];
			switch($param['tag']){
				case 'pro':
					$this->receiveBidsByPro($param);
					break;
				case 'mid':
					$this->receiveBidsByMem($param);
					break;
				default:
					$this->assign('searchError', '请选择上方查询条件！');
					$param['tag'] = 'pro';
			}
		}
		$this->assign('param', $param);
		$this->display();
	}
	
	
	/**
	 * 根据项目查找接到的投标单
	 * @param unknown $param
	 */
	private function receiveBidsByPro(&$param){
		if(empty($_REQUEST['words'])){
			$this->assign('searchError', '请输入项目编号！');
		}else{
			$param['words'] = $_REQUEST['words'];
			$pro = M('project')->join('zt_sort ON pro_sort=sort_id')->where('pro_sn="'.addslashes($_REQUEST['words']).'"')->find();
			if($pro<=0){
				$this->assign('无效的项目编号'.$_REQUEST['words']);
				return;
			}
			$bid = M('Bidder');
			$where = array(
					'bid_proid'	=> $pro['pro_id'],					// 指定项目的投标
					'bid_state'		=> 1							// 正在投标中 0=>未发布, 1=>应标中, 2=>历史记录, 3=>删除
			);
			$subject 	=  get_summary($pro['pro_subject'], 20);
			$sn				= $pro['pro_sn'];
			$publish	= date('m/d', $pro['pro_publishtime']);
			$open		= $pro['pro_opentime']<$_SERVER['REQUEST_TIME'] ? '<span class="red">已开标</span>' : date('m/d H:i', $pro['pro_opentime']);
			$sorts 		= $pro['sort_name'].' / '.str_replace('|', ' / ', $pro['pro_enums']); 
			$proInfo = '<span>项目：《'.$subject.'》</span> <span>编号：'.$sn.'</span> <span>发标：'.$publish.'</span> <span>开标：'.$open.'</span><span>分类：'.$sorts.'</span>';
			$this->assign('proInfo', $proInfo);
			// total and 1Page
			$total = $bid->where($where)->count();
			if($total==0){
				$this->assign('编号为 '.$_REQUEST['words'].' 的项目暂无任何投标。');
				return;
			}
			import('ORG.Util.Page');
			$page = new Page($total, 8);
			// 分页查询
			$limit = $page->firstRow.",".$page->listRows;
			$pager = $page->shown();
			$this->assign("pager", $pager);
			$join = ' LEFT JOIN zt_project ON bid_proid=pro_id ';
			// 查询字段
			$field = "bid_id,bid_publishtime, bid_sn, bid_mid, bid_status, bid_price, bid_currency, bid_unit, bid_price_flag, pro_opentime";
			$bids = $bid->join($join)->field($field)->where($where)->limit($limit)->select();
			/**
			 * 排序字段
			 * 由于price字段是另外生成，故在此用php而不是mysql排序
			 */
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? SORT_ASC : SORT_DESC;
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = SORT_DESC;
			}
			if(isset($_REQUEST['order'])){
				switch($_REQUEST['order']){
					case 'publish':
						$order = "pro_publishtime";
						break;
					case 'amount':
						$order = "amount";
						break;
					default:
						$order = "bid_publishtime";
				}
				$param['order'] = $_REQUEST['order'];
			}else{
				$order = "bid_publishtime";
			}
			
			$status = array('空','备选','中标');	
			foreach($bids as $k=>&$v){
				if($v['pro_opentime']>time()){
					$v['opentime']	= date('m/d H:i', $v['pro_opentime']);
				}else{
					$v['opentime']	= '<span class="red">已开标</span>';
				}
				//获取投标用户相关信息
				$memInfo = D('Member')->getMemberInfo($v['bid_mid']);
				$v['mem_name']	= empty($memInfo['name']) ? $v['bid_mid'] : $memInfo['name'];
				$v['mem_place']	= empty($memInfo['place']) ? '未知' : $memInfo['place'];
				// 获取报价：未开标考虑是否公开，已开标则公开
				$price = D('Currency')->getCurrencySign($v['bid_currency']).' '.$v['bid_price'].' '.D('Unit')->getUnitName($v['bid_unit']);
				if($v['pro_opentime']>$_SERVER['REQUEST_TIME']){
					$v['price'] = $price;
				}else{
					$v['price'] = ($v['bid_price_flag']==1) ? '开标可见' : $price;
				}
				$v['amount'] = $v['bid_price']*(D('Unit')->getUnitMultiple($v['bid_unit']));
				$v['state'] = $status[$v['bid_status']];
				$orderArr[$k] = $v[$order];
			}
			array_multisort($orderArr, $asc, SORT_NUMERIC , $bids);
			$this->assign('bids', $bids);
		}
	}
	
	/**
	 * 根据用户查找收到的投标单
	 * @param unknown $param
	 */
	private function receiveBidsByMem(&$param){
		if(empty($_REQUEST['words'])){
			$this->assign('searchError', '请输入投标方名称！');
		}else{
			$param['words'] = $_REQUEST['words'];
			$mid = D('Member')->getMemberByName(addslashes($_REQUEST['words']));
			if(empty($mid)){
				$this->assign('没有找到名字里包含 ”'.$_REQUEST['words'].'“ 的用户！');
				return;
			}
			$bid = M('Bidder');
			$where = array(
					'bid_mid'	=> array('in', $mid),		// 指定用户的投标
					'bid_state'		=> 1									// 正在投标中 0=>未发布, 1=>应标中, 2=>历史记录, 3=>删除
			);
			// 匹配开标条件
			if( isset($_REQUEST['status'])){
				if($_REQUEST['status']!='all'){
					$where['_string']	= 'pro_status='.$_REQUEST['status'];
				}
				$param['status'] = $_REQUEST['status'];
				$total = $bid->join('zt_project ON bid_proid=pro_id')->where($where)->count();
			}else{
				// total and Page
				$total = $bid->where($where)->count();
			}
			if($total==0){
				$this->assign('暂无任何投标。');
				return;
			}
			import('ORG.Util.Page');
			$page = new Page($total, 8);
			// 分页查询
			$limit = $page->firstRow.",".$page->listRows;
			$pager = $page->shown();
			$this->assign("pager", $pager);
			$join = ' LEFT JOIN zt_project ON bid_proid=pro_id ';
			// 查询字段
			$field = "bid_id,bid_publishtime, bid_sn, bid_mid, bid_status, bid_price, bid_currency, bid_unit, bid_price_flag, pro_id, pro_subject,pro_sn, pro_opentime";
			$bids = $bid->join($join)->field($field)->where($where)->limit($limit)->select();
			/**
			 * 排序字段
			 * 由于price字段是另外生成，故在此用php而不是mysql排序
			*/
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? SORT_ASC : SORT_DESC;
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = SORT_DESC;
			}
			if(isset($_REQUEST['order'])){
				switch($_REQUEST['order']){
					case 'publish':
						$order = "pro_publishtime";
						break;
					case 'amount':
						$order = "amount";
						break;
					default:
						$order = "bid_publishtime";
				}
				$param['order'] = $_REQUEST['order'];
			}else{
				$order = "bid_publishtime";
			}
				
			$status = array('空','备选','中标');	
			foreach($bids as $k=>&$v){
				if($v['pro_opentime']>time()){
					$v['opentime']	= date('m/d H:i', $v['pro_opentime']);
				}else{
					$v['opentime']	= '<span class="red">已开标</span>';
				}
				//获取投标用户相关信息
				$memInfo = D('Member')->getMemberInfo($v['bid_mid']);
				$v['mem_name']	= empty($memInfo['name']) ? $v['bid_mid'] : $memInfo['name'];
				$v['mem_place']	= empty($memInfo['place']) ? '未知' : $memInfo['place'];
				// 获取报价：未开标考虑是否公开，已开标则公开
				$price = D('Currency')->getCurrencySign($v['bid_currency']).' '.$v['bid_price'].' '.D('Unit')->getUnitName($v['bid_unit']);
				if($v['pro_opentime']>$_SERVER['REQUEST_TIME']){
					$v['price'] = $price;
				}else{
					$v['price'] = ($v['bid_price_flag']==1) ? '开标可见' : $price;
				}
				$v['amount'] = $v['bid_price']*(D('Unit')->getUnitMultiple($v['bid_unit']));
				$v['state'] = $status[$v['bid_status']];
				$orderArr[$k] = $v[$order];
			}
			array_multisort($orderArr, $asc, SORT_NUMERIC , $bids);
			$this->assign('bids', $bids);
		}
	}
	
}