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
		
		
	}

	
	/**
	 * 新建应标
	 * @paramstring $id 项目id
	 * 
	 */
	public function launch($id=0){
		$this->checkMember();
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
		$bid_data = M('bidder')->create();
		$bid_data['bid_proid'] = $id;
		$bid_data['bid_publishtime'] = $_SERVER['REQUEST_TIME'];
		$bid_data['bid_mid'] = $_SESSION['member'];
		$bid_data['bid_sn'] = createBidderSn($_SESSION['member']);
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
			redirect(__URL__.'/saved');
		}else{
			M('Contact')->where('con_id='.$con_data)->delete();
			$this->error('投标失败！服务器开小差了，请稍后再试~');
		}
	}
	
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
	 * 取消投标信息
	 */
	public function cancle(){
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