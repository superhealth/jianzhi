<?php
/**
 * 用户管理模块
 * @author Carl
 *
 */
class MemberAction extends BaseAction{
	private $types = array("个人", "企业");		//用户类型
	private $actives = array("到期", "可用");	//用户续费
	private $states = array("未激活", "已激活", "锁定");	//用户状态
	private $status = array("未审核","审核中", "通过","未通过");	//公司审核状态
	/**
	 * 所有用户
	 */
	public function index(){
		$this->memberCheckActive();
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
		
		$this->assign("types", $this->types);
		$this->assign("actives", $this->actives);
		$this->assign("states", $this->states);
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
		if(!per_check("mem_edit")){
			$this->error("无此权限！");
		}
		$step = (int)$step;
		switch($step){
			case 2:
				$data = M("member")->create();
				dump($data);exit;
				if(M("member")->add($data)){
					if($data['mem_type']==1){
						M("membercompany")->add(array("mc_mid"=>$data['mem_id']));
					}else{
						M("memberperson")->add(array("mp_mid"=>$data['mem_id']));
					}
					$this->watchdog("新增", "添加会员[{$data['mem_id']}]");
					$this->success("添加成功", __ACTION__."/step/3/m/{$data['mem_id']}");
				}else{
					$this->error("添加失败！");
				}
				break;
			case 3:
				if(isset($_REQUEST['m'])){
					$info = M("member")->where("mem_id='{$_REQUEST['m']}'")->find();
					if($info){
						if($info['mem_type']==1){
							$template = "addCompany";
							$id = M("membercompany")->where("mc_mid='{$_REQUEST['m']}'")->getField("mc_id");
							if(!$id){
								$id = M("membercompany")->add(array("mc_mid"=>$data['mem_id']));
							}
						}else{
							$template = "addPerson";
							$id = M("memberperson")->where("mp_mid='{$_REQUEST['m']}'")->getField("mp_id");
							if(!$id){
								$id = M("memberperson")->add(array("mp_mid"=>$data['mem_id']));
							}
						}
						$this->assign("info", $info);
						$this->assign("id", $id);
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
		if(!per_check("mem_edit")){
			$this->error("无此权限！");
		}
		$data = M("memberperson")->create();
		if(M("memberperson")->save($data)){
			$this->watchdog("编辑", "编辑个人会员[{$data['mp_mid']}] 的信息。");
			$this->success("保存成功！", __URL__."/memberInfo/id/{$data['mp_mid']}");
		}else{
			$this->error("保存失败！");
		}
	}
	
	/**
	 * 保存企业会员资料
	 */
	public function saveCompany(){
		if(!per_check("mem_edit")){
			$this->error("无此权限！");
		}
		$data = M("membercompany")->create();
		$flag = false;
		foreach($_FILES as $k=>$v){
			if($v['name']){
				$flag = true;break;
			}
		}
		if($flag){
			$uploadInfo = upload(true,"");
			if($uploadInfo[0]){
				foreach($uploadInfo[1] as $v){
					$att_data = array(
							'att_name'	=> $v['savename'],
							'att_type'	=> $v['extension'],
							'att_size'	=> getFileSize($v['size']),
							'att_mid'		=> $_SESSION['user'],
							'att_time'	=> time()
					);
					$data[$v['key']] = M("attachement")->add($att_data);
				}
			}
		}
		
		if(M("membercompany")->save($data)){
			$this->watchdog("编辑", "编辑企业会员[{$data['mc_mid']}] 的信息。");
			$this->success("保存成功！", __URL__."/memberInfo/id/{$data['mc_mid']}");
		}else{
			$this->error("保存失败！");
		}
	}
	
	/**
	 * 查看会员信息
	 */
	public function memberInfo($id=""){
		$type = M("member")->where("mem_id='{$id}'")->getField("mem_type");
		if($type==1){
			$info = M("member")->join(" zt_membercompany ON mem_id=mc_mid")->where("mc_mid='{$id}'")->find();
			$info['legalscan'] = M("attachement")->where("att_id={$info['mc_legalscan']}")->getField("att_name");
			$info['licencescan'] = M("attachement")->where("att_id={$info['mc_licencescan']}")->getField("att_name");
		}else{
			$info = M("member")->join(" zt_memberperson ON mem_id=mp_mid")->where("mp_mid='{$id}'")->find();
		}
		if(!empty($info)){
			$this->assign("states", $this->states);
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
		if(!per_check("mem_edit")){
			$this->error("无此权限！");
		}
		$data = M("member")->create();
		$data['mem_expiretime'] = strtotime($data['mem_expiretime']);
		if($data['mem_expiretime']>time()){
			$data['mem_active'] = 1;
		}
		if(M("member")->save($data)){
			$this->watchdog("编辑", "编辑会员[{$data['mem_id']}]的基本信息");
			$this->success("保存成功！");
		}else{
			$this->error("保存失败！");
		}
	}
	
	/**
	 * 删除用户
	 */
	public function delMember($id=""){
		
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
			$to = "'".implode("'; '", $to)."'";
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
	 * 检查过期会员
	 */
	private function memberCheckActive(){
		$now = time();
		//上次检查时间
		if(!isset($_SESSION['member_check'])){
			$_SESSION['member_check'] = 0;
		}
		if($_SESSION['member_check']<$now-18){
			M("member")->where("mem_active=1 AND mem_expiretime<={$now}")->setField("mem_active", 0);
			$_SESSION['member_check'] = $now;
		}
	}
	
}

?>