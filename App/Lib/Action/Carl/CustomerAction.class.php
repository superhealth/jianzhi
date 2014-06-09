<?php
class CustomerAction extends BaseAction{
	/**
	 * 客户列表
	 */
	public function index(){
		$customer = M("customer");
		$this->check_new();
		$param = array();
		$map = array();
		// 过滤选项
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['cu_name'] = array("like", "%{$words}%");
				$where['cu_email'] = array("like", "%{$words}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		if(!empty($_REQUEST['cu_new'])&&$_REQUEST['cu_new']=="new"){
			$map['cu_new'] = 0;
			$param['cu_new'] = $_REQUEST['cu_new'];
		}
		$this->assign("param", $param);
		// total总数
		$total = $customer->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		//排序规则
		$order = "cu_new, cu_time DESC";
		
		$customers = $customer->where($map)->order($order)->limit($limit)->select();
		$this->assign("state", array("未激活", "已激活", "已屏蔽"));
		$this->assign("customer_edit", per_check("customer_edit"));
		//换色
		if(!empty($param['words'])){
			foreach($customers as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("customers", $customers);
		$this->display();
	}
	
	/**
	 * check_new()
	 */
	protected function check_new(){
		$new_customer = M("customer")->where("cu_new=0")->select();
		foreach($new_customer as $v){
			if(time()-$v['cu_time']>=7*24*3600){
				M("customer")->where("cu_id=".$v['cu_id'])->setField("cu_new", 1);
			}
		}
	}
	/**
	 *查看客户资料
	 */
	public function customer_view($cu_id=""){
		if($cu_id){
			$cu = M("customer");
			$cu_data = $cu->where("cu_id={$cu_id}")->find();
			$this->assign("cu_data", $cu_data);
			$this->display();
		}else{
			$msg = response_msg("INVALID_ARGUMENT");
			redirect(__URL__."/index/msg/{$msg}");
		}
	}
	
	/**
	 * 保存客户信息
	 */
	public function customer_save(){
		if(!per_check("customer_edit")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$cu = M("customer");
			$data = $cu->create();
			$data['cu_birth'] = strtotime($data['cu_birth']);
			$data['cu_state'] = $data['cu_state']=="on"?1:0;
			if($cu->save($data)){
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/customer_view/cu_id/{$data['cu_id']}/msg/{$msg}");
	}
	
	/**
	 * 冻结、解封客户
	 */
	public function customer_edit(){
		if(!per_check("customer_edit")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			if($_GET['action']=="live"){
				$cu_id = stripslashes($_GET['cu_id']);
				$cu = M("customer");
				if($cu->where("cu_id={$cu_id}")->setField("cu_state", 1)){
					$cu_name = $cu->where("cu_id={$cu_id}")->getField("cu_name");
					$msg = response_msg("OPERATION_SUCCESS");
					$this->watchdog("编辑", "成功激活客户账号 {$cu_name}");
				}else{
					$msg = response_msg("OPERATION_FAILD");
				}
			}else if($_GET['action']=="freeze"){
				$cu_id = stripslashes($_GET['cu_id']);
				$cu = M("customer");
				if($cu->where("cu_id={$cu_id}")->setField("cu_state", 2)){
					$cu_name = $cu->where("cu_id={$cu_id}")->getField("cu_name");
					$msg = response_msg("OPERATION_SUCCESS");
					$this->watchdog("编辑", "成功冻结客户账号 {$cu_name}");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}else{
				$msg = response_msg("INVALID_ARGUMENT");
			}
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	
	
	/**
	 * 客户留言
	 */
	public function messages(){
		$message = M("message");
		$param = array();
		$map = array();
		// 过滤选项
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['msg_title'] = array("like", "%{$words}%");
				$where['cu_name'] = array("like", "%{$words}%");
				$where['msg_content'] = array("like", "%{$words}%");
				$where['_logic'] = "or";
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
			$map['u_name'] = array("like", "%{$_REQUEST['u_name']}%");
			$param['u_name'] = $_REQUEST['u_name'];
		}
		if(isset($_REQUEST['msg_new']) && $_REQUEST['msg_new']=="new"){
			$map['msg_new'] = 0;
			$param['msg_new'] = $_REQUEST['msg_new'];
		}
		$this->assign("param", $param);
		$join = " chuango_customer ON cu_id=msg_cu_id";
		// total总数
		$total = $message->join($join)->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		//排序规则
		$order = "msg_new, msg_time DESC";
		//连接查询
		
	
		$messages = $message->join($join)->where($map)->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($messages as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("msg_read", per_check("msg_read"));
		$this->assign("state", array("new", "已读"));
		$this->assign("messages", $messages);
		$this->display();
	}
	
	public function message_view($msg_id=""){
		$response = array(
			"code" 	=> 0
		);
		if(!per_check("msg_read")){
			$response['code'] = 1;
			$response['msg'] = "操作受限！";
		}else{
			$message = M("message");
			$join = "chuango_customer ON msg_cu_id=cu_id";
			$field = "msg_title, msg_time, cu_name, cu_email, msg_content";
			$msg = $message->field($field)->join($join)->where("msg_id={$msg_id}")->find();
			if(!empty($msg)){
				if($msg["msg_new"]==0){
					$message->where("msg_id={$msg_id}")->setField("msg_new", 1);
				}
				$this->watchdog("查看", "查看了客户".$msg['cu_name']."的留言消息".$msg['msg_title'] );
				$msg['msg_time'] = timeFormat($msg['msg_time']);
				$response['data'] = $msg;
			}else{
				$response['code'] = 1;
				$response['msg'] = "参数错误！".$message->getError();
			}
		}
		echo json_encode_nonull($response);
	}
	
	/**
	 * 设置消息已读
	 * @param string $chkt
	 */
	public function message_read($chkt=""){
		if(!per_check("msg_read")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/messages/msg/{$msg}");
			exit;
		}
		if(empty($chkt)){
			$msg = response_msg("INVALID_ARGUMENT");
		}else{
			if(is_array($chkt)){
				$map['msg_id'] = array("in", $chkt);
			}else{
				$map['msg_id'] = $chkt;
			}
			$message = M("message");
			$msgs = $message->where($map)->getField("msg_title", true);
			if($message->where($map)->setField("msg_new", 1)){
				$this->watchdog("编辑", " 标记 ".implode(",", $msgs)." 为已读");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/messages/msg/{$msg}");
	}
	
	/**
	 * 客户回馈
	 */
	public function feedback(){
		$feedback = M("feedback");
		$param = array();
		$map = array();
		// 过滤选项
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['fd_comment'] = array("like", "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		if(isset($_REQUEST['group'])&&$_REQUEST['group']!="all"){
			$map['fd_group'] = $_REQUEST['group'];
			$param['group'] = $_REQUEST['group'];
		}
		if(isset($_REQUEST['purpose'])&&$_REQUEST['purpose']!="all"){
			$map['fd_purpose'] = $_REQUEST['purpose'];
			$param['purpose'] = $_REQUEST['purpose'];
		}
		$this->assign("param", $param);
		// total总数
		$total = $feedback->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		$feedbacks = $feedback->where($map)->order("fd_time DESC")->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($feedbacks as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$group = M("options")->where("op_group='group'")->order("op_order")->getField("op_text text, op_text", true);
		$purpose = M("options")->where("op_group='purpose'")->order("op_order")->getField("op_text text, op_text", true);
		$this->assign("feedbacks", $feedbacks);
		$this->assign("group", $group);
		$this->assign("purpose", $purpose);
		$this->display();
	}
	
	/**
	 * feedback 选项管理
	 */
	public function feedback_opt(){
		$opt = M("options");
		$groups = $opt->where("op_group='group'")->order("op_order")->select();
		$this->assign("groups", $groups);
		$purpose = $opt->where("op_group='purpose'")->order("op_order")->select();
		$this->assign("purpose", $purpose);
		$this->display();
	}
	public function feedbackopt_add($type=""){
		if(!per_check("feedback_manger")){
			echo response_msg("操作受限！", "error", true);
			exit;
		}
		if($type=="group" || $type=="purpose"){
			$html = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="op_group" value="%type%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加选项</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="op_text">选项内容</label>
						<div class="controls">
							 <input type="text" id="op_text" name="op_text" value="">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="op_value">选项值</label>
						<div class="controls">
						  	<input type="text" id="op_value" name="op_value" value="">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="op_order">排序</label>
						<div class="controls">
						  	<input type="text" id="op_order" name="op_order">
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="feed_commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			
			echo str_replace(array("%type%","%url%"), array($type, __URL__."/feedbackopt_save"), $html);exit;
		}else{
			echo response_msg("参数错误！", "error", true);exit;
		}
	}
	
	public function feedbackopt_save(){
		if(!per_check("feedback_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$data = M("options")->create();
			$info = array("group"=>"角色人群", "purpose"=>"访问目的");
			if(array_key_exists("op_id", $data)){
				if(M("options")->save($data)){
					$this->watchdog("编辑", "修改feedback的{$info[$data['op_group']]}选项'{$data['op_text']}'");
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}else{
				if(M("options")->add($data)){
					$this->watchdog("新增", "添加feedback的{$info[$data['op_group']]}选项'{$data['op_text']}'");
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}
		}
		redirect(__URL__."/feedback_opt/msg/{$msg}");
	}
	
	public function feedbackopt_edit($op_id=""){
		if(!per_check("feedback_manger")){
			echo response_msg("操作受限！", "error", true);
			exit;
		}
		if($op_id){
			$html = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="op_group" value="%type%" />
				<input type="hidden" name="op_id" value="%id%" />	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加选项</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="op_text">选项内容</label>
						<div class="controls">
							 <input type="text" id="op_text" name="op_text" value="%text%">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="op_value">选项值</label>
						<div class="controls">
						  	<input type="text" id="op_value" name="op_value" value="%value%">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="op_order">排序</label>
						<div class="controls">
						  	<input type="text" id="op_order" name="op_order" value="%order%" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="feed_commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$option = M("options")->where("op_id={$op_id}")->find();
			echo str_replace(array("%type%", "%id%", "%text%", "%value%", "%order%", "%url%"), array($option['op_group'], $option['op_id'], $option['op_text'], $option['op_value'], $option['op_order'], __URL__."/feedbackopt_save"), $html);
		}else{
			echo response_msg("参数错误！", "error", true);
			exit;
		}
	}
	
	public function feedbackopt_delete($chkt=""){
		if(!per_check("feedback_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$map['op_id'] = array("in", $chkt);
			$info = array("group"=>"角色人群", "purpose"=>"访问目的");
			$texts = M("options")->where($map)->getField("op_text", true);
			if(M("options")->where($map)->delete()){
				$this->watchdog("删除", "删除feedback选项'".implode(",", $texts)."'");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/feedback_opt/msg/{$msg}");
	}
}