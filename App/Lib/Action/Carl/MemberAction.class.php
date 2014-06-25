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
	private $sexes = array("保密", "男", "女");	//用户性别
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
		// 属性对应关系
		$this->assign("types", $this->types);
		$this->assign("actives", $this->actives);
		$this->assign("states", $this->states);
		//排序条件
		$order = "";
		if(isset($_REQUEST['order'])){
			$order = $_REQUEST['order'];
			$param['order'] = $_REQUEST['order'];
		}
		$this->assign("param", $param);
		$total = $m->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//查询字段
		$field = "mem_id, mem_state,mem_regtime,mem_type,mem_active ,mem_logincount	,mem_rank";
		$members = $m->field($field)->where($map)->order($order)->limit($limit)->select();
		$this->assign("members", $members);
		$this->display();
	}
	
	/**
	 * 添加会员
	 */
	public function add($action =""){
		if(!per_check("mem_edit")){
			$this->error("无此权限！");
		}
		if($action=="save"){
			//添加会员第二步，保存会员基本信息
			$data = M("member")->create();
			$data['mem_regtime'] = strtotime($data['mem_regtime']);
			$data['mem_expiretime'] = strtotime($data['mem_expiretime']);
			$data['mem_password'] = md5($data['mem_password']);
			if(M("member")->add($data)){
				if($data['mem_type']==1){
					M("membercompany")->add(array("mc_mid"=>$data['mem_id']));
				}else{
					M("memberperson")->add(array("mp_mid"=>$data['mem_id']));
				}
				$this->watchdog("新增", "添加会员[{$data['mem_id']}]");
				$this->success("添加成功", __URL__."/fillInfo/mid/{$data['mem_id']}");
			}else{
				$this->error("添加失败！");
			}
		}else{
			// 属性对应关系
			$this->assign("types", $this->types);
			$this->assign("actives", $this->actives);
			$this->assign("states", $this->states);
			$this->assign("now", time());
			$this->assign("init", time()+31*24*3600);			
			$this->display();
		}
	}
	/**
	 * 
	 */
	public function fillInfo($mid=""){
		//根据会员类型继续完善对应资料
		if(!empty($mid)){
			$info = M("member")->where("mem_id='{$mid}'")->find();
			if($info){
				if($info['mem_type']==1){
					//企业会员
					$template = "Member:addCompany";
					$id = M("membercompany")->where("mc_mid='{$mid}'")->getField("mc_id");
					if(!$id){
						$id = M("membercompany")->add(array("mc_mid"=>$mid));
					}
					$this->assign("status", $this->status);
				}else{
					//个人会员
					$template = "Member:addPerson";
					$id = M("memberperson")->where("mp_mid='{$mid}'")->getField("mp_id");
					if(!$id){
						$id = M("memberperson")->add(array("mp_mid"=>$mid));
					}
					$this->assign("sexes", $this->sexes);
				}
				$this->assign("info", $info);
				$this->assign("id", $id);
				$this->display($template);
			}else{
				$this->error("参数错误! ", __URL__."/memberInfo/id/{$id}");
			}
		}else{
			$this->error("参数错误! ", __URL__."/memberInfo/id/{$id}");
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
		//检查是否文件上传
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
					//保存附件ID
					$data[$v['key']] = M("attachement")->add($att_data);
					//获取原附件ID
					$oldAtt[] = M("membercompany")->where("mc_id={$data['mc_id']}")->getField($v['key']);
				}
			}
		}
		// 保存个人信息
		if(M("memberperson")->save($data)){
			//删除原附件
			if(!empty($oldAtt)){
				attDelete($oldAtt);
			}
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
		// 检查是否有文件上传
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
					$oldAtt[] = M("membercompany")->where("mc_id={$data['mc_id']}")->getField($v['key']);
				}
			}
		}
		//保存资料
		if(M("membercompany")->save($data)){
			//删除旧附件
			if(!empty($oldAtt)){
				attDelete($oldAtt);
			}
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
		//会员类型
		$type = M("member")->where("mem_id='{$id}'")->getField("mem_type");
		if($type==1){
			//企业会员
			$info = M("member")->join(" zt_membercompany ON mem_id=mc_mid")->where("mc_mid='{$id}'")->find();
			if(empty($info)){
				$this->error("参数错误！");
			}
			// 企业相关证件扫描附件
			$info['legalscan'] = M("attachement")->where("att_id={$info['mc_legalscan']}")->getField("att_name");
			$info['licencescan'] = M("attachement")->where("att_id={$info['mc_licencescan']}")->getField("att_name");
			// 企业审核状态
			$this->assign("status", $this->status);
		}else{
			//个人会员
			$info = M("member")->join(" zt_memberperson ON mem_id=mp_mid")->where("mp_mid='{$id}'")->find();
			if(empty($info)){
				$this->error("参数错误！");
			}
			// 个人证件扫描附件
			$info['idscan'] = M("attachement")->where("att_id={$info['mp_idscan']}")->getField("att_name");
			// 性别枚举
			$this->assign("sexes", $this->sexes);
		}
		$this->assign("states", $this->states);
		$this->assign("info", $info);
		$this->assign("type", $type);
		$this->display();
	}
	/**
	 * 修改会员信息
	 */
	public function saveInfo(){
		if(!per_check("mem_edit")){
			$this->error("无此权限！");
		}
		$data = M("member")->create();
		// 到期时间，检查是否到期/续费
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
	
	public function delMember($id=""){
		
	}
	 */
	
	/**
	 * 锁定用户
	 */
	public function block($id=""){
		$map = array("mem_id"=> array("in", $id));
		if(M("member")->where($map)->setField("mem_state", 2)){
			$ids = is_array($id)?implode(",", $id):$id;
			$this->watchdog("锁定", "锁定用户：{$ids}");
			$this->success("锁定成功！");
		}else{
			$this->error("锁定失败！");
		}
	}
	
	/**
	 * 解锁用户
	 */
	public function unBlock($id=""){
		$map = array("mem_id"=> array("in", $id));
		if(M("member")->where($map)->setField("mem_state", 1)){
			$ids = is_array($id)?implode(",", $id):$id;
			$this->watchdog("解锁", "解锁用户：{$ids}");
			$this->success("解锁成功！");
		}else{
			$this->error("解锁失败！");
		}
	}
	
	/**
	 * 新建系统通知
	 */
	public function notice($to=""){
		if(is_array($to)){
			$to = implode(";", $to);
		}
		$this->assign("to", $to);
		$this->display();
	}
	/**
	 * 发送系统通知
	 */
	public function sendNotice(){
		$data = M("notice")->create();
		$data['no_tiem'] = time();
		if(M("notice")->add($data)){
			$this->watchdog("新增", "向用户 <span class=''>{$data['no_mid']}</span> 发送系统消息 <strong>{$data['no_subject']}</strong> ");
			$this->success("发送成功！");
		}else{
			$this->error("发送失败！");
		}
	}
	
	/**
	 * 会员人工续费界面（银行转账方式）
	 */
	public function renewal($id=""){
		$this->assign("id", $id);
		$duefee = D("Sysconf")->getConf("cfg_duefee");
		$this->assign("duefee", $duefee);
		$this->display();
	}
	
	/**
	 * 人工续费操作
	 */
	public function renewalSave(){
		$duefee = M("duefee");
		$data = $duefee->create();
		$m = M("member")->where("mem_id='{$data['due_mid']}'")->find();
		//检查会员
		if(empty($m)){
			$this->error("不存在的会员<span class='red'>{$data['due_mid']}</span>");
		}
		dump($data['due_discount']);
		$data['due_discount'] = (int)($data['due_discount']);
		if($data['due_discount']<1){
			dump($data['due_discount']);
			$this->error("没有选择续费年限！");
		}
		$data['due_price'] = $GLOBALS['sys_cfg']['cfg_duefee'];
		$data['due_amount'] = $data['due_price']*$data['due_discount'];
		$data['due_operator'] = $_SESSION['user'];
		$data['due_createtime'] = time();
		$data['due_paystatus'] = 	1;
		$data['due_paytime'] = time();
		if($duefee->add($data)){
			$id = $duefee->getLastInsID();
			//会员续费情况		
			$member = new MemberModel("member");
			if($member->renewal($data['due_mid'], $data['due_discount'])){
				$detail = "会员<span class='blue'>{$data['due_mid']}</span> 续费 <strong class='yellow'>{$data['due_discount']}</strong>年；操作员：<span class='green'>[{$data['due_operator']}]</span>. ";
				$this->watchdog("续费", $detail);
				$this->success("续费成功！", __URL__."/memberInfo/id/{$data['due_mid']}");
			}else{
				//回滚
				$duefee->where("due_id={$id}")->delete();
				$this->error("续费失败！".$member->getError());
			}
		}else{
			$this->error("续费操作失败！");
		}
	}
	
	/**
	 * 续费记录
	 */
	public function dueRecord(){
		$m = M("duefee");
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
		// 属性对应关系
		$this->assign("types", $this->types);
		$this->assign("actives", $this->actives);
		$this->assign("states", $this->states);
		//排序条件
		$order = "";
		if(isset($_REQUEST['order'])){
			$order = $_REQUEST['order'];
			$param['order'] = $_REQUEST['order'];
		}
		$this->assign("param", $param);
		$total = $m->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 12, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//查询字段
		$field = "mem_id, mem_state,mem_regtime,mem_type,mem_active ,mem_logincount	,mem_rank";
		$members = $m->field($field)->where($map)->order($order)->limit($limit)->select();
		$this->assign("members", $members);
		$this->display();
		
		$this->display();
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
		if($_SESSION['member_check']<$now-1800){
			M("member")->where("mem_active=1 AND mem_expiretime<={$now}")->setField("mem_active", 0);
			$_SESSION['member_check'] = $now;
		}
	}
	
	/**
	 * 查找会员
	 */
	public function findMember($key=""){
		//查找所有
		$members = M("member")->where("mem_id LIKE '%{$key}%'")->order("mem_expiretime DESC")->getField("mem_id",true);
		$html = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h3>查找会员</h3></div>';
		if(empty($members)){
			$html .= '<div class="modal-body"><h3 class="red">没有找到任何会员！</h3></div>';
		}else{
			$html .= '<div class="modal-body" style="overflow:scroll;"><div class="row-fluid">';
			foreach($members as $k=>$v){
				if($k%3==0){
					$html .= '</div><div class="row-fluid">';
				}
				$html .= '<div class="member-select" data-val="'.$v.'">'.$v.' <i class="icon icon-check icon-color"></i></div>';
			}
		}
		$html .= '</div></div><div class="modal-footer"><a href="#" class="btn" data-dismiss="modal">关闭</a></div>';
		echo $html;
	}
	
	/**
	 * 检查会员是否存在
	 */
	public function check($id=""){
		if(M("member")->where("mem_id='{$id}'")->count()){
			echo "<h3 class='red'>已存在该用户！</h3>";
		}else{
			echo "<h3 class='green'>用户名可用</h3>";
		}
	}
}

?>