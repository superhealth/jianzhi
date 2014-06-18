<?php
/**
 * 用户管理模块
 * @author Carl
 *
 */
class MemberAction extends BaseAction{
	/**
	 * 所有用户
	 */
	public function index(){
		$m = M("member");
		//筛选条件
		$map = array();
		//页面参数
		$param = array();
		if(isset($_REQUEST['state']) && $_REQUEST['state']!="all"){
			$map['mem_state']  = $_REQUEST['state'];
			$param['state'] = $_REQUEST['state'];
		}
		if(isset($_REQUEST['active']) && $_REQUEST['active']!="all"){
			$map['mem_active']  = $_REQUEST['active'];
			$param['active'] = $_REQUEST['active'];
		}
		if(isset($_REQUEST['type']) && $_REQUEST['type']!="all"){
			$map['mem_type']  = $_REQUEST['type'];
			$param['type'] = $_REQUEST['type'];
		}
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['mem_id']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		
		$types = array("个人", "企业");
		$this->assign("types", $types);
		$actives = array("到期", "可用");
		$this->assign("actives", $actives);
		$states = array("未激活", "已激活", "锁定");
		$this->assign("states", $states);
		//排序条件
		$order = "";
		if(isset($_REQUEST['order'])){
			$order = $_REQUEST['order'];
			$param['words'] = $_REQUEST['words'];
		}
		$this->assign("param", $param);
		$total = $m->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$field = "mem_id, mem_state,mem_regtime,mem_type,mem_active ,mem_logincount	,mem_rank";
		$members = $m->field($field)->where($map)->order($order)->limit($limit)->select();
		$this->assign("members", $members);
		$this->display();
	}
	
	/**
	 * 添加会员
	 */
	public function add($step=""){
		$step = (int)$step;
		switch($step){
			case 2:
				$data = M("member")->create();
				dump($data);exit;
				if(M("member")->add($data)){
					$this->success("添加成功", __ACTION__."/step/3/m/{$data['mem_id']}");
				}else{
					$this->error("添加失败！");
				}
				break;
			case 3:
				if(isset($_REQUEST['m'])){
					$info = M("member")->where("mem_id={$_REQUEST['m']}")->find();
					if($info){
						$template = $info['mem_type']==0 ? "addPerson" : "addCompany";
						$this->assign("info", $info);
						$this->display($template);
					}else{
						$this->error("参数错误! ", __URL__."/index");
					}
				}else{
					$this->error("参数错误! ", __URL__."/index");
				}
				break;
			default:
				$this->display();
		}
	}
	
	/**
	 * 保存个人会员资料
	 */
	public function savePerson(){
		
	}
	
	/**
	 * 保存企业会员资料
	 */
	public function saveCompany(){
		
	}
	
	/**
	 * 查看会员信息
	 */
	public function memberInfo($id=""){
		$type = M("member")->where("mem_id='{$id}'")->getField("mem_type");
		if($type==1){
			$info = M("member")->join(" zt_membercompany ON mem_id=mc_mid")->where("mc_mid='{$id}'")->find();
		}else{
			$info = M("memberperson")->join(" zt_memberperson ON mem_id=mp_mid")->where("mp_mid='{$id}'")->find();
		}
		if(!empty($info)){
			$this->assign("info", $info);
			$this->assign("type", $type);
			$this->display();
		}else{
			$this->error("参数错误！");
		}
	}
	/**
	 * 修改会员信息
	 */
	public function saveInfo(){
		
	}
	
	/**
	 * 保存个人用户资料
	 */
	public function personInfo(){
		
	}
	
	/**
	 * 保存企业用户资料
	 */
	public function companyInfo(){
		
	}
	
	
	/**
	 * 删除用户
	 */
	public function delMember(){
		
	}
	
	/**
	 * 锁定用户
	 */
	public function block($id=""){
		
	}

	/**
	 * 新建系统通知
	 */
	public function notice($to=""){
		if(is_array($to)){
			$to = "'".implode("'; '", $pieces)."'";
		}else if($to == "group"){
			
		}else{
			
		}
	}
	/**
	 * 发送系统通知
	 */
	public function sendNotice(){
		
	}
	
	/**
	 * 会员人工续费界面（银行转账方式）
	 */
	public function renewal($id=""){
		
	}
	
	/**
	 * 人工续费操作
	 */
	public function renewalSave(){
		
	}
	
	/**
	 * 人工续费记录
	 */
	public function renewalRecord(){
		
	}
	
	/**
	 * 
	 */
	
	
}

?>