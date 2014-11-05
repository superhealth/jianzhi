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
		$this->checkMember();
		$this->leftInit();
		$bid = M('Bidder');
		$map = array(
				'bid_state'=> 1,													// 已发布
				'bid_mid'	=> $_SESSION['member']		//
		);
		$param = array('status'=> 'all');
		// 匹配开标条件
		if( isset($_REQUEST['status']) && $_REQUEST['status']!='all'){
			$map['_string']	= 'pro_status='.addslashes($_REQUEST['status']);
			$param['status'] = $_REQUEST['status'];
		}else{
			$map['_string'] = 'pro_status in (1,2)';
		}
		// 查询
		if( isset($_REQUEST['words']) && strlen($_REQUEST['words'] )>2){
		$filter = addslashes($_REQUEST['words']);
		$mid = D('Member')->getMemberByName($filter);
		$map['_complex'] = array(
				'pro_subject'		=> array('like', '%'.$filter.'%'),
				'pro_sn'				=> array('like', '%'.$filter.'%'),
				'bid_sn'				=> array('like', '%'.$filter.'%'),
				'_logic'					=> 'or'
		);
		$param['words'] = $_REQUEST['words'];
		}

		$order = "bid_publishtime DESC";	//默认排序
		if(isset($_REQUEST['order'])){
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? 'ASC' : 'DESC';
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = 'DESC';
			}
			switch($_REQUEST['order']){
				case 'publish':
					$order = "bid_publishtime ".$asc;
					break;
				case 'open':
					$order = "pro_opentime ".$asc;
					break;
				case 'bids':
					$order = "bidders ".$asc;
					break;
				default:
					$order = "bid_publishtime DESC";
			}
			$param['order'] = $_REQUEST['order'];
		}else{
			$order = "bid_publishtime DESC";
		}
		$join = ' LEFT JOIN zt_project ON bid_proid=pro_id';
		// 分页
		$total = $bid->join($join)->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 8, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				" LEFT JOIN zt_project ON bid_proid=pro_id"
		);
		// 查询字段
		$field = "bid_id, bid_sn, bid_publishtime, bid_status, pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_opentime, pro_status";
		$bids = $bid->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		foreach ($bids as &$v){
			if($v['pro_opentime']>time()){
				$v['opentime']	= date('Y/m/d', $v['pro_opentime']);
			}else{
				$v['opentime']	= '<span class="red">已开标</span>';
			}
			$v['pro_owner'] = D('Member')->getMemberName($v['pro_mid']);
		}
		// 中标状态
		$this->assign("status", array('空','备选','中标'));
		$this->assign("lists", $bids);
		$this->display();
	}

	
	/**
	 * 新建应标
	 * @paramstring $id 项目id
	 * 
	 */
	public function launch($id=0){
		$this->checkMember();
		$status = D('Member')->getMemberStatus($_SESSION['member']);
		if($status!=="1"){
			$this->error('Sorry~ 您还未进行实名认证，不能进行投标！<a href="'.__GROUP__.'/Member/verify">点此马上认证</a>', __GROUP__.'/Member/verify');
		}
		
		$field = 'pro_id, pro_sn, pro_mid, pro_subject, pro_prop, pro_limit, pro_quantity, pro_unit, sort_name, pro_enums, pro_publishtime, pro_updatetime,  pro_opentime, pro_step, pro_status';
		$proInfo = M('project')->field($field)->join('`zt_sort` ON `zt_sort`.`sort_id`=`zt_project`.`pro_sort`')->where('pro_id="'.$id.'"')->find();
		if(empty($proInfo)){
			$this->_empty();
		}
		
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$proInfo['pro_opentime']){
			$this->error('Sorry~ 该项目已开标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		//检查是否重复投标
		$members = D('Project')->getProjectMembers($id);
		if(is_array($members)&&in_array($_SESSION['member'], $members)){
			$this->error('Sorry~ 您已经进行过投标了，不能重复投标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		//检查是否同一用户
		if($proInfo['pro_mid'] == $_SESSION['member']){
			$this->error('Sorry~ 您不能对自己的项目进行投标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		//检查是否可以投标
		$memType = M('Member')->where('mem_id = "'.$_SESSION['member'].'"')->getField('mem_type');
		$limits = array('不限', '个人', '企业');
		if($proInfo['pro_limit']==0 || $proInfo['pro_limit']==($memType+1)){
			//项目封面
			$proInfo['cover'] = D('Attachement')->getAttSrc($proInfo['pro_cover']);
			//项目发布者状态
			$proInfo['mem_status'] = D('Member')->getMemberStatus($proInfo['pro_mid']);
			//生产属性
			$this->assign('props', D('Property')->getProps());
			//投标限制
			$this->assign('limits', $limits);
			//币值单位
			$this->assign('units', D('Unit')->getUnits());
			//货币类型
			$this->assign('currencys', D('Currency')->getCurrencyBySign());
			//税费类型
			$this->assign('taxes', D('Taxes')->getTaxes());
			// 联系人为空，查找用户默认联系方式
			$memberInfo = M('member')->where('mem_id="'.$_SESSION['member'].'"')->find();
			// 用户邮箱
			$proInfo['con_email'] = $memberInfo['mem_email'];
			// 通过验证
			if($memberInfo['mem_state'] > 0){
				// 企业用户
				if($memberInfo['mem_type'] > 0){
					$mcInfo = M('membercompany')->where('mc_mid="'.$_SESSION['member'].'"')->find();
					$proInfo['con_tel'] = $mcInfo['mc_tel'];
					$proInfo['con_name'] = $mcInfo['mc_legal'];
					unset($mcInfo);
				}
				// 个人用户
				else{
					$mpInfo = M('memberperson')->where('mp_mid="'.$_SESSION['member'].'"')->find();
					$proInfo['con_tel'] = $mpInfo['mp_tel'];
					$proInfo['con_name'] = $mpInfo['mp_name'];
					unset($mpInfo);
				}
			}
			unset($memberInfo);
			$this->assign('project', $proInfo);
			$this->display();
		}else{
			$this->error('Sorry~该项目限定招标对象为'.$limits[$proInfo['pro_limit']].'用户', __GROUP__.'/Project/detail/id/'.$id);
		}
	}
	/**
	 * 保存投标
	 */
	public function add(){
		$this->checkMember();
		$id = addslashes($_REQUEST['id']);
		if(empty($id)){
			$this->_empty();
		}
		$proInfo = M('Project')->where("pro_id={$id}")->find();
		if(empty($proInfo)){
			$this->_empty();
		}
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$proInfo['pro_opentime']){
			$this->error('Sorry~ 该项目已开标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		// 检查是否投过标
		$count = M('Bidder')->where('bid_proid='.$id.' AND bid_mid="'.$_SESSION['member'].'"')->count();
		if($count>0){
			$this->error('Sorry~ 该项目您已经投过了标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		$bid_data = M('bidder')->create();
		$bid_data['bid_proid'] = $id;
		$bid_data['bid_publishtime'] = $_SERVER['REQUEST_TIME'];
		$bid_data['bid_mid'] = $_SESSION['member'];
		$bid_data['bid_sn'] = createBidderSn($_SESSION['member']);
		$bid_data['bid_state']	= 1;
		// 上传投标附件
		foreach ($_FILES as $f){
			if(!empty($f['name'])){
				$upFlag = true;break;
			}
		}
		if($upFlag){
			$uploadInfo = upload($_SESSION['member'], false);
			if($uploadInfo[0]){
				//添加到附件表
				$att_data = D("Attachement")->addAtt($uploadInfo[1], $_SESSION['member']);
				if(!empty($att_data)){
					foreach($att_data as $c=>$v){
						$bid_data[$c] = $v;
					}
				}
			}else{
				$this->error("文件上传失败！".$uploadInfo[1]);
			}
		}
		//保存联系人
		$con_data = M('Contact')->create();
		$con_id = M('Contact')->add($con_data);
		$bid_data['bid_contact'] = $con_id;
		if(M('Bidder')->add($bid_data)){
			$_SESSION['newBid'] = M('Bidder')->getLastInsID();
			redirect(__URL__.'/launchEd');
		}else{
			M('Contact')->where('con_id='.$con_data)->delete();
			$this->error('投标失败！服务器开小差了，请稍后再试~');
		}
	}
	
	/**
	 * 投标结果
	 */
	public function launchEd(){
		if(isset($_SESSION['newBid'])){
			$join = array(
					'zt_project ON pro_id=bid_proid',
					'zt_sort ON zt_sort.sort_id = zt_project.pro_sort'
				);
			$bidInfo = M('Bidder')->join($join)->where('bid_id="'.$_SESSION['newBid'].'" AND bid_mid="'.$_SESSION['member'].'"')->find();
			if(empty($bidInfo)){
				$this->_empty();
			}
			//项目封面
			$bidInfo['cover'] = D('Attachement')->getAttSrc($bidInfo['pro_cover']);
			//项目发布者状态
			$bidInfo['mem_status'] = D('Member')->getMemberStatus($bidInfo['pro_mid']);
			$this->assign('props', D('Property')->getProps());
			$this->assign('limits', array('不限', '个人', '企业'));
			$this->assign('bidInfo', $bidInfo);
			$this->display();
		}else{
			$this->_empty();
		}
	}
	
	/**
	 * 修改投标
	 * @param string $id 投标单ID
	 */
	public function modify($id=0){
		$this->checkMember();
		$join = array(
				'zt_project ON pro_id=bid_proid',
				'zt_sort ON zt_sort.sort_id = zt_project.pro_sort',
				'zt_contact ON bid_contact = con_id'
		);
		$bidInfo = M('Bidder')->join($join)->where('bid_id="'.$id.'" AND bid_mid="'.$_SESSION['member'].'"')->find();
		if(empty($bidInfo)){
			$this->_empty();
		}
		
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$bidInfo['pro_opentime']){
			$this->error('Sorry~ 所投项目已开标，无法修改！');
		}
		//项目封面
		$bidInfo['cover'] 		= D('Attachement')->getAttSrc($bidInfo['pro_cover']);
		//报价单
		$bidInfo['quoted'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_quoted'].'"')->find();
		//投标书
		$bidInfo['tenders'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_tenders'].'"')->find();
		//生产属性
		$this->assign('props', D('Property')->getProps());
		//投标限制
		$this->assign('limits', array('不限', '个人', '企业'));
		//币值单位
		$this->assign('units', D('Unit')->getUnits());
		//货币类型
		$this->assign('currencys', D('Currency')->getCurrencyBySign());
		//税费类型
		$this->assign('taxes', D('Taxes')->getTaxes());
		// 项目发布者信息
		$memInfo = D('Member')->getMemberInfo($bidInfo['pro_mid']);
		// 投标用户信息
		$userInfo = D('Member')->getMemberInfo($bidInfo['bid_mid']);
		if(empty($bidInfo['con_name'])){
			$bidInfo['con_name'] = $userInfo['name'];
		}
		if(empty($bidInfo['con_tel'])){
			$bidInfo['con_tel'] = $userInfo['tel'];
		}
		if(empty($bidInfo['con_email'])){
			$bidInfo['con_email'] = $userInfo['mem_email'];
		}
		$this->assign('bidInfo', $bidInfo);
		$this->assign('memInfo', $memInfo);
		$this->assign('userInfo', $userInfo);
		$this->display();
	}
	/**
	 * 保存修改
	 */
	public function save(){
		$this->checkMember();
		$bid_data = M('bidder')->create();
		//所投项目详情
		$proid = M('Bidder')->where('bid_id='.$bid_data['bid_id'].' AND bid_mid="'.$_SESSION['member'].'"')->getField('bid_proid');
		$proInfo = M('Project')->where('pro_id='.$proid)->find();
		if(empty($proInfo)){
			$this->_empty();
		}
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$proInfo['pro_opentime']){
			$this->error('Sorry~ 所投项目已开标，无法修改！', __GROUP__.'/Bid/');
		}
		
		$bid_data['bid_updatetime'] = $_SERVER['REQUEST_TIME'];
		// 上传投标附件
		foreach ($_FILES as $f){
			if(!empty($f['name'])){
				$upFlag = true;break;
			}
		}
		if($upFlag){
			$uploadInfo = upload($_SESSION['member'], false);
			if($uploadInfo[0]){
				//添加到附件表
				$att_data = D("Attachement")->addAtt($uploadInfo[1], $_SESSION['member']);
				if(!empty($att_data)){
					foreach($att_data as $c=>$v){
						$bid_data[$c] = $v;
					}
				}
			}else{
				$this->error("文件上传失败！".$uploadInfo[1]);
			}
		}
		//保存联系人
		$con_data = M('contact')->create();
		$con_id = M('Bidder')->where('bid_id='.$bid_data['bid_id'])->getField('bid_contact');
		if(empty($con_id)){
			$con_id = M('contact')->add($con_data);
		}else{
			M('contact')->where('con_id='.$con_id)->save($con_data);
		}
		$bid_data['bid_contact'] 	= $con_id;
		if(M('Bidder')->save($bid_data)){
			$_SESSION['bidModify'] = $bid_data['bid_id'];
			$proInfo = M('bidder')->join('LEFT JOIN zt_project ON bid_proid=pro_id')->field('pro_id, pro_subject, pro_mid, pro_status, bid_id, bid_mid')->where('bid_id='.$bid_data['bid_id'])->find();
			//向招标owner发送取消消息
			$bid_owner	= D('Member')->getMemberName($proInfo['bid_mid']);
			$subject = '用户更改了对您项目的投标信息';
			$content = '，用户 <a class="colorbox" href="'.__GROUP__.'/Member/view/id/'.$proInfo['bid_mid'].'">'.$bid_owner.'</a>更新了对项目《'.$proInfo['pro_subject'].'》的投标。<a href="'.__GROUP__.'/Bid/detail/id/'.$proInfo['bid_id'].'">点击查看</a>';
			D('Notice')->sendBidNotice($proInfo['pro_mid'], $subject, $content);
			
			redirect(__URL__.'/saved');
		}else{
			M('Contact')->where('con_id='.$con_data)->delete();
			$this->error('投标失败！服务器开小差了，请稍后再试~');
		}
	}
	/**
	 * 保存投标修改
	 */
	public function saved(){
		if(isset($_SESSION['bidModify'])){
			$join = array(
					'zt_project ON pro_id=bid_proid',
					'zt_sort ON zt_sort.sort_id = zt_project.pro_sort'
			);
			$bidInfo = M('Bidder')->join($join)->where('bid_id="'.$_SESSION['bidModify'].'" AND bid_mid="'.$_SESSION['member'].'"')->find();
			if(empty($bidInfo)){
				$this->_empty();
			}
			//项目封面
			$bidInfo['cover'] = D('Attachement')->getAttSrc($bidInfo['pro_cover']);
			
			//项目发布者状态
			$memInfo = D('Member')->getMemberInfo($bidInfo['pro_mid']);
			$this->assign('memInfo', $memInfo);
			//投标者状态
			$userInfo = D('Member')->getMemberInfo($bidInfo['bid_mid']);
			$this->assign('userInfo', $userInfo);
			$this->assign('props', D('Property')->getProps());
			$this->assign('limits', array('不限', '个人', '企业'));
			$this->assign('bidInfo', $bidInfo);
			$this->display();
		}else{
			$this->_empty();
		}
	}
	
	/**
	 * 查看投标信息
	 * @param string $sn 投标序列号
	 */
	public function detail($id=0){
		$join = array(
				'zt_project ON pro_id=bid_proid',
				'zt_sort ON zt_sort.sort_id = zt_project.pro_sort',
				'zt_contact ON bid_contact = con_id'
		);
		$bidInfo = M('Bidder')->join($join)->where('bid_id="'.$id.'"')->find();
		if(empty($bidInfo)){
			$this->_empty();
		}
		if($bidInfo['bid_state']>1){
			$this->error('该次投标已被取消！');
		}
		//项目封面
		$bidInfo['cover'] 		= D('Attachement')->getAttSrc($bidInfo['pro_cover']);
		//报价单
		$bidInfo['quoted'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_quoted'].'"')->find();
		//投标书
		$bidInfo['tenders'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_tenders'].'"')->find();
		//生产属性
		$this->assign('props', D('Property')->getProps());
		//投标限制
		$this->assign('limits', array('不限', '个人', '企业'));
		//币值单位
		$this->assign('units', D('Unit')->getUnits());
		//货币类型
		$this->assign('currencys', D('Currency')->getCurrencyBySign());
		//税费类型
		$this->assign('taxes', D('Taxes')->getTaxes());
		// 项目发布者信息
		$memInfo = D('Member')->getMemberInfo($bidInfo['pro_mid']);
		// 投标用户信息
		$userInfo = D('Member')->getMemberInfo($bidInfo['bid_mid']);
		if(empty($bidInfo['con_name'])){
			$bidInfo['con_name'] = $userInfo['name'];
		}
		if(empty($bidInfo['con_tel'])){
			$bidInfo['con_tel'] = $userInfo['tel'];
		}
		if(empty($bidInfo['con_email'])){
			$bidInfo['con_email'] = $userInfo['mem_email'];
		}
		$this->assign('bidInfo', $bidInfo);
		$this->assign('memInfo', $memInfo);
		$this->assign('userInfo', $userInfo);
		$this->display();
	}

	/**
	 * 取消投标
	 * 条件：本人发布的投标， 已发布且所投项目已开标
	 */
	public function delete($id=""){
		$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'bid_id'		=> $id,
				'bid_mid'	=> $_SESSION['member'],
				'bid_state'	=> 1,
		);
		$join = ' LEFT JOIN zt_project ON bid_proid=pro_id';
		$proInfo = M('bidder')->join($join)->field('pro_id, pro_subject, pro_mid, pro_status, bid_mid')->where($where)->find();
		if(!empty($proInfo)){
			if($proInfo['pro_status'] > 1 ){
				//设置项目状态
				M('bidder')->where('bid_id='.$id)->setField('bid_state', 3);	
				//向招标owner发送取消消息
				$bid_owner	= D('Member')->getMemberName($proInfo['bid_mid']);
				$subject = '投标已取消通知';
				$content = '很遗憾，用户 <a color="colorbox" href="'.__GROUP__.'/Member/view/id/'.$proInfo['bid_mid'].'">'.$bid_owner.'</a> 取消了对项目《'.$proInfo['pro_subject'].'》的投标。';
				D('Notice')->sendBidNotice($proInfo['pro_mid'], $subject, $content);
				$this->ajaxReturn($response);
			}else{
				$response['code'] 	= 1;
				$response['data']	= 'Sorry~该项目还未开标，不能删除投标单！';
				$this->ajaxReturn($response);
			}
		}else{
			$response['code'] 	= 1;
			$response['data']	= 'Sorry~投标单不存在！';
			$this->ajaxReturn($response);
		}
	}
	/**
	 * 删除投标档案
	 * 条件：本人发布的投标
	 */
	public function delHistory($id=""){
		$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'bid_id'		=> $id,
				'bid_mid'	=> $_SESSION['member'],
				'bid_state'	=> 2,
		);
		if(M('bidder')->where($where)->setField('bid_state', 3)){
		}else{
			$response['code'] 	= 1;
			$response['data']	= 'Sorry~投标单不存在！';
		}
		$this->ajaxReturn($response);
	}
	
	/**
	 * 投标历史档案
	 */
	public function history(){
		$this->checkMember();
		$this->leftInit();
		$bid = M('Bidder');
		$map = array(
				'bid_state'=> 2,													// 存为档案
				'bid_mid'	=> $_SESSION['member']		// 
		);
		$param = array('status'=> 'all');
		// 匹配开标条件
		if( isset($_REQUEST['status']) && $_REQUEST['status']!='all'){
			switch($_REQUEST['status']){
				case 'kong'		: $map['bid_status'] = 0;		break;
				case 'bei'		: $map['bid_status'] = 1;		break;
				case 'zhong'	: $map['bid_status'] = 2;		break;
			}
			$param['status'] = $_REQUEST['status'];
		}
		// 查询
		if( isset($_REQUEST['words']) && strlen($_REQUEST['words'] )>2){
			$filter = addslashes($_REQUEST['words']);
			$mid = D('Member')->getMemberByName($filter);
			$map['_complex'] = array(
					'pro_subject'		=> array('like', '%'.$filter.'%'),
					'pro_sn'				=> array('like', '%'.$filter.'%'),
					'bid_sn'				=> array('like', '%'.$filter.'%'),
					'pro_mid'			=> array('like', '%'.$filter.'%'),
					'_logic'					=> 'or'
			);
			$param['words'] = $_REQUEST['words'];
		}
		
		$order = "bid_publishtime DESC";	//默认排序
		if(isset($_REQUEST['order'])){
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? 'ASC' : 'DESC';
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = 'DESC';
			}
			switch($_REQUEST['order']){
				case 'publish':
					$order = "bid_publishtime ".$asc;
					break;
				case 'open':
					$order = "pro_opentime ".$asc;
					break;
				case 'bids':
					$order = "bidders ".$asc;
					break;
				default:
					$order = "bid_publishtime DESC";
			}
			$param['order'] = $_REQUEST['order'];
		}else{
			$order = "bid_publishtime DESC";
		}
		$join = ' LEFT JOIN zt_project ON bid_proid=pro_id';
		// 分页
		$total = $bid->join($join)->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 8, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				" LEFT JOIN zt_project ON bid_proid=pro_id"
		);
		// 查询字段
		$field = "bid_id, bid_sn, bid_publishtime, bid_status, pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_opentime, pro_status";
		$bids = $bid->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		foreach ($bids as &$v){
			if($v['pro_opentime']>time()){
				$v['opentime']	= date('Y/m/d', $v['pro_opentime']);
			}else{
				$v['opentime']	= '<span class="red">已开标</span>';
			}
			$v['pro_owner'] = D('Member')->getMemberName($v['pro_mid']);
		}
		// 中标状态
		$this->assign("status", array('空','备选','中标'));
		$this->assign("lists", $bids);
		$this->display();
	}
	
	/**
	 * 移入历史档案区 取消投标
	 */
	public function toHistory($id=""){
	$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'bid_id'		=> $id,
				'bid_mid'	=> $_SESSION['member'],
				'bid_state'	=> 1,
		);
		$join = ' LEFT JOIN zt_project ON bid_proid=pro_id';
		$proInfo = M('bidder')->join($join)->field('pro_id, pro_subject, pro_mid, pro_status, bid_mid')->where($where)->find();
		if(!empty($proInfo)){
			if($proInfo['pro_status'] > 1 ){
				//设置项目状态
				M('bidder')->where('bid_id='.$id)->setField('bid_state', 2);	
				//向招标owner发送取消消息
				$bid_owner	= D('Member')->getMemberName($proInfo['bid_mid']);
				$subject = '投标已取消通知';
				$content = '很遗憾，用户 <a class="colorbox" href="'.__GROUP__.'/Member/view/id/'.$proInfo['bid_mid'].'">'.$bid_owner.'</a> 取消了对项目《'.$proInfo['pro_subject'].'》的投标。';
				D('Notice')->sendBidNotice($proInfo['pro_mid'], $subject, $content);
				$this->ajaxReturn($response);
			}else{
				$response['code'] 	= 1;
				$response['data']	= 'Sorry~该项目还未开标，不能存档！';
				$this->ajaxReturn($response);
			}
		}else{
			$response['code'] 	= 1;
			$response['data']	= 'Sorry~投标单不存在！';
			$this->ajaxReturn($response);
		}
	}
	
	/**
	 * 添加投标到草稿箱
	 * @param string $id
	 */
	public function addDraft(){
		$this->checkMember();
		$id = addslashes($_REQUEST['id']);
		if(empty($id)){
			$this->_empty();
		}
		$proInfo = M('Project')->where("pro_id={$id}")->find();
		if(empty($proInfo)){
			$this->_empty();
		}
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$proInfo['pro_opentime']){
			$this->error('Sorry~ 该项目已开标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		// 检查是否投过标
		$count = M('Bidder')->where('bid_proid='.$id.' AND bid_mid="'.$_SESSION['member'].'"')->count();
		if($count>0){
			$this->error('Sorry~ 该项目您已经投过了标！', __GROUP__.'/Project/detail/id/'.$id);
		}
		$bid_data = M('bidder')->create();
		$bid_data['bid_proid'] = $id;
		$bid_data['bid_createtime'] = $_SERVER['REQUEST_TIME'];
		$bid_data['bid_mid'] = $_SESSION['member'];
		$bid_data['bid_sn'] = createBidderSn($_SESSION['member']);
		$bid_data['bid_state']	= 0;
		// 上传投标附件
		foreach ($_FILES as $f){
			if(!empty($f['name'])){
				$upFlag = true;break;
			}
		}
		if($upFlag){
			$uploadInfo = upload($_SESSION['member'], false);
			if($uploadInfo[0]){
				//添加到附件表
				$att_data = D("Attachement")->addAtt($uploadInfo[1], $_SESSION['member']);
				if(!empty($att_data)){
					foreach($att_data as $c=>$v){
						$bid_data[$c] = $v;
					}
				}
			}else{
				$this->error("文件上传失败！".$uploadInfo[1]);
			}
		}
		//保存联系人
		$con_data = M('Contact')->create();
		$con_id = M('Contact')->add($con_data);
		$bid_data['bid_contact'] = $con_id;
		if(M('Bidder')->add($bid_data)){
			redirect(__URL__.'/drafts');
		}else{
			M('Contact')->where('con_id='.$con_data)->delete();
			$this->error('保存草稿失败！服务器开小差了，请稍后再试~');
		}
	}
	/**
	 * 编辑草稿
	 * @param string $id 草稿id
	 */
	public function editDraft($id){
		$this->checkMember();
		$join = array(
				'zt_project ON pro_id=bid_proid',
				'zt_sort ON zt_sort.sort_id = zt_project.pro_sort',
				'zt_contact ON bid_contact = con_id'
		);
		$bidInfo = M('Bidder')->join($join)->where('bid_id="'.$id.'" AND bid_mid="'.$_SESSION['member'].'"')->find();
		if(empty($bidInfo)){
			$this->_empty();
		}
		
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$bidInfo['pro_opentime']){
			$this->error('Sorry~ 所投项目已开标！');
		}
		//项目封面
		$bidInfo['cover'] 		= D('Attachement')->getAttSrc($bidInfo['pro_cover']);
		//报价单
		$bidInfo['quoted'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_quoted'].'"')->find();
		//投标书
		$bidInfo['tenders'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_tenders'].'"')->find();
		//生产属性
		$this->assign('props', D('Property')->getProps());
		//投标限制
		$this->assign('limits', array('不限', '个人', '企业'));
		//币值单位
		$this->assign('units', D('Unit')->getUnits());
		//货币类型
		$this->assign('currencys', D('Currency')->getCurrencyBySign());
		//税费类型
		$this->assign('taxes', D('Taxes')->getTaxes());
		// 项目发布者信息
		$memInfo = D('Member')->getMemberInfo($bidInfo['pro_mid']);
		// 投标用户信息
		$userInfo = D('Member')->getMemberInfo($bidInfo['bid_mid']);
		if(empty($bidInfo['con_name'])){
			$bidInfo['con_name'] = $userInfo['name'];
		}
		if(empty($bidInfo['con_tel'])){
			$bidInfo['con_tel'] = $userInfo['tel'];
		}
		if(empty($bidInfo['con_email'])){
			$bidInfo['con_email'] = $userInfo['mem_email'];
		}
		$this->assign('bidInfo', $bidInfo);
		$this->assign('memInfo', $memInfo);
		$this->assign('userInfo', $userInfo);
		$this->display();
	}
	
	/**
	 * 删除草稿
	 */
	public function delDraft(){
		$id = addslashes($_REQUEST['id']);
		$this->checkMember();
		$response = array('code'=>0, 'data'=>'');
		$where = array(
				'bid_id'		=> $id,
				'bid_mid'	=> $_SESSION['member'],
				'bid_state'	=> 0,
		);
		if(M('bidder')->where($where)->delete()){
			
		}else{
			$response['code'] 	= 1;
			$response['data']	= 'Sorry~投标单不存在！';
		}
		$this->ajaxReturn($response);
	}
	
	/**
	 * 草稿箱
	 */
	public function drafts(){
		$this->checkMember();
		$this->leftInit();
		$bid = M('bidder');
		$map = array(
				'bid_state'=> 0,													// 未发布的草稿
				'bid_mid'	=> $_SESSION['member']		//
		);
		$param = array('status'=> 'all');
		// 匹配开标条件
		if( isset($_REQUEST['status']) && $_REQUEST['status']!='all'){
			$map['_string']	= 'pro_status='.addslashes($_REQUEST['status']);
			$param['status'] = $_REQUEST['status'];
		}else{
			$map['_string'] = 'pro_status in(1,2)';
		}
		// 查询
		if( isset($_REQUEST['words']) && strlen($_REQUEST['words'] )>2){
			$filter = addslashes($_REQUEST['words']);
			$mid = D('Member')->getMemberByName($filter);
			$map['_complex'] = array(
					'pro_subject'		=> array('like', '%'.$filter.'%'),
					'pro_sn'				=> array('like', '%'.$filter.'%'),
					'bid_sn'				=> array('like', '%'.$filter.'%'),
					'_logic'					=> 'or'
			);
			$param['words'] = $_REQUEST['words'];
		}
		
		$order = "bid_publishtime DESC";	//默认排序
		if(isset($_REQUEST['order'])){
			if(isset($_REQUEST['asc'])){
				$asc = $_REQUEST['asc']=='1' ? 'ASC' : 'DESC';
				$param['asc'] = $_REQUEST['asc'];
			}else{
				$asc = 'DESC';
			}
			switch($_REQUEST['order']){
				case 'publish':
					$order = "bid_publishtime ".$asc;
					break;
				case 'open':
					$order = "pro_opentime ".$asc;
					break;
				case 'bids':
					$order = "bidders ".$asc;
					break;
				default:
					$order = "bid_publishtime DESC";
			}
			$param['order'] = $_REQUEST['order'];
		}else{
			$order = "bid_publishtime DESC";
		}
		$join = ' LEFT JOIN zt_project ON bid_proid=pro_id';
		// 分页
		$total = $bid->join($join)->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 8, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				" LEFT JOIN zt_project ON bid_proid=pro_id"
		);
		// 查询字段
		$field = "bid_id, bid_sn, bid_createtime, bid_status, pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_opentime, pro_status";
		$bids = $bid->join($join)->field($field)->where($map)->order($order)->limit($limit)->select();
		foreach ($bids as &$v){
			if($v['pro_opentime']>time()){
				$v['opentime']	= date('Y/m/d', $v['pro_opentime']);
			}else{
				$v['opentime']	= '<span class="red">已开标</span>';
			}
			$v['pro_owner'] = D('Member')->getMemberName($v['pro_mid']);
		}
		// 中标状态
		$this->assign("status", array('空','备选','中标'));
		$this->assign("lists", $bids);
		$this->display();
	}
	
	/**
	 * 收藏项目列表
	 */
	public function collections(){
		$this->checkMember();
		$project = M("collection");
		$map = array(
				'co_mid'	=> $_SESSION['member']
		);
		// 连接查询项目
		$join = 'LEFT JOIN zt_project ON co_proid=pro_id';
		//筛选条件
		$param = array();
		// 项目分类
		if(isset($_REQUEST['sortid']) && $_REQUEST['sortid']!="all"){
			$map['pro_sort']  = addslashes($_REQUEST['sortid']);
			$param['sortid'] = $_REQUEST['sortid'];
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
		$total = $project->join($join)->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		$this->assign('param', $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		// 连接查询
		$join = array(
				'LEFT JOIN zt_project ON co_proid=pro_id',
				"LEFT JOIN (SELECT bid_proid,count(*) bidders FROM zt_bidder GROUP BY bid_proid) b ON pro_id=b.bid_proid"
		);
		// 查询字段
		$field = "pro_id, pro_sn, pro_subject, LEFT(pro_subject, 20) subject, pro_mid, pro_sort, pro_enums, pro_prop, pro_publishtime, pro_limit, pro_place, pro_opentime, pro_startstop, pro_status, IFNULL(bidders, 0) bidders";
		$projects = $project->field($field)->join($join)->where($map)->order($order)->limit($limit)->select();
		
		// 类别
		$sorts = D('Sort')->getSorts();
		$this->assign('sorts', $sorts);
		// 所有属性
		$props = D("Property")->getProps();
		$this->assign("props", $props);
		// 用户投标限制
		$this->assign("limits", $this->limits);
		foreach ($projects as &$v){
			$starstop = explode("-", $v['pro_startstop']);
			$v['pro_endtime'] = mb_substr($starstop[1], 0, strpos($starstop[1], '日')+1, 'utf-8');
			$v['pro_place']	= str_replace(array('|','中国','省','市'),array(' ','','',''), $v['pro_place']);
			$v['mem_place'] = D('Member')->getMemberPlace($v['pro_mid']);
			$v['mem_place'] = str_replace(array('|','中国','省','市'),array(' ','','',''), $v['mem_place']);
			$v['sorts'] = enumsDecode($v['pro_enums']);
			array_unshift($v['sorts'], $sorts[$v['pro_sort']]);
			$v['sorts'] = implode(' / ', $v['sorts']);
		}
		$this->assign("projects", $projects);
		$this->display();
	}
	
	
	/**
	 * 收藏项目
	 * @param int $id
	 */
	public function collection($id=''){
		$ajaxData = array('code'=>0, 'data'=>'');
		if(empty($id)){
			echo json_encode_nonull(array('code'=>0, 'data'=> 'Wrong Argument!')); exit;
		}
		if(empty($_SESSION['member'])){
			$ajaxData['code'] = 100;
			$ajaxData['data'] = __GROUP__."/Member/login/flag/true";
		}else{
			if(D('Collection')->addCollection($id, $_SESSION['member'])){
				$ajaxData['data'] = '取消收藏';
				$ajaxData['id'] 		= M('Collection')->getLastInsID();
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
	public function cancelCollect($id=''){
		$ajaxData = array('code'=>0, 'data'=>'');
		if(empty($_SESSION['member'])){
			$ajaxData['code'] = 100;
			$ajaxData['data'] = __GROUP__."/Member/login/flag/true";
		}else{
			$proid = M('collection')->where('co_id='.$id)->getField('co_proid');
			if(D('Collection')->where(array('co_id'=>$id, 'co_mid'=>$_SESSION['member']))->delete()){
				$ajaxData['data'] = '收藏项目';
				$ajaxData['id'] 		= $proid;
				$ajaxData['url'] 	= __URL__.'/collection';
				$ajaxData['code'] = 1;
			}else{
				$ajaxData['data'] = '取消收藏失败！'.D('Collection')->getError();
			}
		}
		echo json_encode_nonull($ajaxData);exit;
	}
	
	/**
	 * 收到的应标详情
	 * @param number $id 应表单id
	 */
	public function receive($id=0){
		$this->checkMember();
		$join = array(
				'zt_project ON pro_id=bid_proid',
				'zt_sort ON zt_sort.sort_id = zt_project.pro_sort',
				'zt_contact ON bid_contact = con_id'
		);
		$bidInfo = M('Bidder')->join($join)->where('bid_id="'.$id.'" AND pro_mid="'.$_SESSION['member'].'"')->find();
		if(empty($bidInfo)){
			$this->_empty();
		}
		if($bidInfo['bid_state']>1){
			$this->error('该次投标已被取消！');
		}
		//项目封面
		$bidInfo['cover'] 		= D('Attachement')->getAttSrc($bidInfo['pro_cover']);
		//报价单
		$bidInfo['quoted'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_quoted'].'"')->find();
		//投标书
		$bidInfo['tenders'] 	= M('attachement')->where('att_id="'.$bidInfo['bid_tenders'].'"')->find();
		//生产属性
		$this->assign('props', D('Property')->getProps());
		//投标限制
		$this->assign('limits', array('不限', '个人', '企业'));
		//币值单位
		$this->assign('units', D('Unit')->getUnits());
		//货币类型
		$this->assign('currencys', D('Currency')->getCurrencyBySign());
		//税费类型
		$this->assign('taxes', D('Taxes')->getTaxes());
		// 项目发布者信息
		$memInfo = D('Member')->getMemberInfo($bidInfo['pro_mid']);
		// 投标用户信息
		$userInfo = D('Member')->getMemberInfo($bidInfo['bid_mid']);
		if(empty($bidInfo['con_name'])){
			$bidInfo['con_name'] = $userInfo['name'];
		}
		if(empty($bidInfo['con_tel'])){
			$bidInfo['con_tel'] = $userInfo['tel'];
		}
		if(empty($bidInfo['con_email'])){
			$bidInfo['con_email'] = $userInfo['mem_email'];
		}
		$this->assign('bidInfo', $bidInfo);
		$this->assign('memInfo', $memInfo);
		$this->assign('userInfo', $userInfo);
		$this->display();
	}
	
	/**
	 * 选择应表单
	 * $id 应表单id
	 * $pro 项目id
	 * $
	 */
	public function selectBid(){
		$this->checkMember();
		$id = $_POST['id'];
		$pro = $_POST['pro'];
		$status = $_POST['status'];
		switch($status){
			case 'bei':
				$bidStatus = 1;
				break;
			case 'zhong':
				$bidStatus = 2;
				break;
		}
		
		$jdata = array();
		
		$data = array(
			'bid_id'			=> $id,
			'bid_proid'	=> $pro, 
		);
		$bidder = M('Bidder')->field('bid_id, bid_mid')->where($data)->find();
		if(empty($bidder)){
			
		}
		if(M('Bidder')->where($data)->setField('bid_status', $bidStatus)){
			$proInfo = M('project')->field('pro_id, pro_subject')->where('pro_id='.$pro)->find();
			$statusName = array('', '');
			$sub = '招标项目更新通知';
			$cont = '，您在项目《'.$proInfo['pro_subject'].'》的投标被选为“”。<a href="'.__GROUP__.'/Project/detail/id/'.$proInfo['pro_id'].'">点此</a>查看项目详情。';
			D('Notice')->sendProNotice($bidder['bid_mid'], $sub, $cont);
		}
		
		$this->ajaxReturn($jdata);
	}
	
	
	
}