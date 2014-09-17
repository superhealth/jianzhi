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
	public function launch($id=""){
		$this->checkMember();
		$proInfo = M('Project')->where("pro_id={$id}")->find();
		if(empty($proInfo)){
			$this->_empty();
		}
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$proInfo['pro_opentime']){
			$this->error('Sorry~ 该项目已开标！');
		}
		//检查是否可以投标
		$memType = M('Member')->where('mem_id = "'.$_SESSION['member'].'"')->getField('mem_type');
		$limits = array('不限', '个人', '企业');
		if($proInfo['pro_limit']==0 || $proInfo['pro_limit']==($memType+1)){
			$this->assign('project', $proInfo);
			$this->display();
		}else{
			$this->error('Sorry~该项目限定招标对象为'.$limits[$proInfo['pro_limit']].'用户');
		}
		
	}
	/**
	 * 保存投标
	 */
	public function add(){
		$this->checkMember();
		$proInfo = M('Project')->where("pro_id={$_REQUEST['bid_proid']}")->find();
		if(empty($proInfo)){
			$this->_empty();
		}
		//检查是否开标
		if($_SERVER['REQUEST_TIME']>$proInfo['pro_opentime']){
			$this->error('Sorry~ 该项目已开标！');
		}
		$bid_data = M('bidder')->create();
		$bid_data['bid_createtime'] = $_SERVER['REQUEST_TIME'];
		$bid_data['bid_mid'] = $_SESSION['member'];
		$bid_data['bid_sn'] = createBidderSn($_SESSION['member']);
		if(M('Bidder')->add($bid_data)){
			$this->launchEd();
		}else{
			$this->error('投标失败！服务器开小差了，请稍后再试~');
		}
	}
	
	
	/**
	 * 新建应标成功
	 * @param 
	 */
	public function launchEd(){
		$this->display('launchEd');
	}
	/**
	 * 修改投标
	 * @param string $id 投标单ID
	 */
	public function modify($id=""){
		$this->checkMember();
		$bidInfo = M('Bidder')->where('bid_id='.$id)->find();
		//检查是否有效ID
		if(empty($bidInfo)){
			$this->_empty();
		}
		//检查是否本人
		if($bidInfo['bid_mid']!==$_SESSION['member']){
			$this->_empty();
		}
		//检查是否开标
		$proOpentime = M('Porject')->where('pro_id='.$bidInfo['bid_proid'])->getField('pro_opentime');
		if($_SERVER['REQUEST_TIME'] < $proOpentime){
			$this->assign('bidInfo', $bidInfo);
			$this->display();
		}else{
			$this->error('Sorry~ 所投项目已开标，无法修改！');
		}
	}
	/**
	 * 保存修改
	 */
	public function save(){
		$this->checkMember();
		$bidInfo = M('Bidder')->where('bid_id='.$_REQUEST['bid_id'])->find();
		//检查是否有效ID
		if(empty($bidInfo)){
			$this->_empty();
		}
		//检查是否本人
		if($bidInfo['bid_mid']!==$_SESSION['member']){
			$this->_empty();
		}
		//检查是否开标
		$proOpentime = M('Porject')->where('pro_id='.$bidInfo['bid_proid'])->getField('pro_opentime');
		if($_SERVER['REQUEST_TIME'] < $proOpentime){
			$this->assign('bidInfo', $bidInfo);
			$this->display();
		}else{
			$this->error('Sorry~ 所投项目已开标，无法修改！');
		}
	}
	/**
	 * 查看投标信息
	 * @param string $sn 投标序列号
	 */
	public function view($id=""){
		
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