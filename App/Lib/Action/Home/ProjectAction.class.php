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
		redirect(__URL__.'/createStep1');
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
		$sorts = D('Sort')->getSorts();
		$this->assign('sorts', $sorts);
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
		$this->assign('newProject', $newProjectInfo);
		$this->display();
	}
	
	/**
	 * 保存项目资料 项目信息
	 */
	public function createInfo1(){
		$data = M("project")->create();
		$data['pro_startstop'] = $_POST['pro_start'].'-'.$_POST['pro_end'];
	}
	
	/**
	 * 发布项目
	 *  步骤4
	 */
	public function createStep4(){
		$this->checkMember();
		if(empty($_COOKIE['newProject'])){
			if(empty($_POST['pro_type'])){
				$this->error('请选择类别！', __URL__.'/createStep2');
			}
			$data = array(
					'pro_sort'	=> $_POST['pro_type'],
					'pro_emun'	=> $_POST['pro_enum'],
					
					
					
					
					
					'pro_sn'		=> createProjectSn($_SESSION['member'])
			);
			if(M('project')->add($data)){
				setcookie('newProject', $data, time()+3600*24);
				$this->assign('newProject', $data);
			}
		}
		$this->assign('newProject', $_COOKIE['newProject']);
		$this->display();
		if(!empty($_SESSION['newProject'])){
			$newProject = $_SESSION['newProject'];
			unset($_SESSION['newProject']);
		}else if(!empty($_COOKIE['newProject'])){
			$newProject = unserialize($_COOKIE['newProject']);
		}
		$this->assign('newProject', $newProject);
	}
	
	/**
	 * 保存项目资料 对投标要求
	 */
	public function createInfo2(){
		
		M('project')->save($data);
	}
	
	public function createEd(){
		$this->checkMember();
		
		$this->error('保存失败！请稍后再试或联系我们的客服');
		
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