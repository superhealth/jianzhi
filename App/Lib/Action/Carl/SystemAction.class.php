<?php
class SystemAction extends BaseAction{
	/* 系统参数 */
	public function index(){
		// total
		$total = M("sysconf")->count();
		import("Org.Util.Page");
		$page = new Page($total, 12);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$sysconf = M("sysconf")->limit($limit)->select();
		foreach($sysconf as &$v){
			$v['tag'] = switch_input($v['value']);
		}
		$this->assign("sysconf", $sysconf);
		$this->display();
	}
	
	/**
	 * 添加系统参数
	 * 
	 */
	function sysconf_add($action=""){
		if($action=="add"){
			if(!per_check("cfg_edit")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$cfg = M("sysconf");
				$data = $cfg->create();
				$count = $cfg->where("key='{$data[key]}'")->count();
				if($count>0){
					$msg = $msg = response_msg("ADD_EXIST");
				}elseif($cfg->add($data)){
					$detail = "添加新配置参数%key%,表示为%desc%";
					$this->watchdog("新增", str_replace(array("%key%", "%desc%"), array($data['key'], $data['desc']), $detail));
					$msg = $msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = $msg = response_msg("OPERATION_FAILED");
				}
			}
			redirect(__URL__."/index/msg/{$msg}");
		}else{
			if(!per_check("cfg_edit")){
				echo response_msg("操作受限!", "error", true);exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加用户</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="key">参数名</label>
						<div class="controls">
							 <input type="text" id="key" name="key">
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="value">参数值</label>
						<div class="controls">
						  	<input type="text" id="value" name="value">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="type">类型</label>
						<div class="controls">
						  	<input type="text" id="type" name="type">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="desc">描述</label>
						<div class="controls">
							<input type="text" id="desc" name="desc">
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHTML );
		}
	} 
	
	/**
	 * 保存系统参数
	 */
	function sysconf_save(){
		if(!per_check("cfg_edit")){
			$this->error("无此权限！");
		}
		$data = array();
		foreach($_POST as $k=>$v){
			if(substr($k, 0, 4)=="key_"){
				$data['id'] = substr($k, 4);
				$data['value'] = $v;
				M("sysconf")->save($data);
			}
		}
		redirect(__URL__."/index");
	}
	
	/**
	 * 更新缓存
	 */
	function sysconf_update(){
		if(!per_check("cache_update")){
			$this->error("无此权限！");
		}else{
			if(D("Sysconf")->updateCache()){
				$this->success("更新成功！");
			}else{
				$this->error("更新失败！");
			}
		}
	}
	/* 用户 */
	public function users(){
		$user = M("admin");
		$param = array();
		$map = array();
		if($_REQUEST['filter'] == "filter"){
			if(!empty($_REQUEST['name'])){
				$map['name'] = array("like", "%{$_REQUEST['name']}%");
				$param['name'] = $_REQUEST['name'];
			}
		}
		// total
		$total = $user->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		$order = "role";
		$join = " zt_role ON zt_admin.role=zt_role.role_id";
		$users = $user->join($join)->where($map)->order($order)->limit($limit)->select();
		$this->assign("user_edit", per_check("admin_edit"));
		$this->assign("users", $users);
		$roles = M("role")->select();
		$this->assign("roles", $roles);
		$this->display();
	}
	
	public function chpw($action=""){
		if($action=="edit"){
			$data = M("admin")->create();
			$data['pass'] = md5($_POST['new_pass']);
			if(M("admin")->save($data)){
				$user_info = M("admin")->where("id={$data['id']}")->find();
				$this->watchdog("编辑", "用户 {$user_info['name']}修改登录密码");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
			$referer = $_SERVER['HTTP_REFERER'];
			redirect($referer."/msg/{$msg}");
		}elseif($action=="validate"){
			$pass = M("admin")->where("name='{$_SESSION['user']}'")->getField("pass");
			if($pass==md5($_GET['pass'])){
				echo "correct";
			}else{
				echo "wrong";
			}
		}else{
			$responseHTML = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改密码</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="u_name">用户名</label>
						<div class="controls">
							 <span>%name%</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="old_pass">初始密码</label>
						<div class="controls">
						  	<input type="password" id="old_pass" name="old_pass" value="">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="new_pass">新密码</label>
						<div class="controls">
						  	<input type="password" id="new_pass" name="new_pass" value="">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="re_pass">确认密码</label>
						<div class="controls">
						  	<input type="password" id="re_pass" name="re_pass">
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="chpw_commit" data-act="%url%">修改</a>
				</div></fieldset></form>';
			$user_info = M("admin")->where("name='{$_SESSION['user']}'")->find();
			echo str_replace(array("%id%", "%name%", "%url%"), array($user_info['id'], $user_info['name'], __URL__."/chpw"), $responseHTML);
		}
	}
	
	/* 编辑用户 */
	public function userEdit($id="",$action=""){
		if($action=="edit"){
			$data = M("admin")->create();
			$data['pass'] = md5($_POST['u_pass']);
			if(!per_check("admin_edit")){
				$msg = response_msg("ACCESS_DENIED");
			}elseif(M("admin")->save($data)){
				$user_info = M("admin")->where("id={$data['id']}")->find();
				$this->watchdog("编辑", "修改用户 {$user_info['name']}的登录密码");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("INVALID_ARGUMENT");
			}
			redirect(__URL__."/users/msg/{$msg}");
		}else{
			if(!per_check("admin_edit")){
				echo response_msg("操作受限！", "error", true);exit;
			}elseif(empty($id)){
				echo response_msg("参数错误！", "error", true);
				exit;
			}else{
				$responseHTML = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改密码</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="name">用户名</label>
						<div class="controls">
							 <span>%name%</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="u_pass">重置密码</label>
						<div class="controls">
						  	<input type="password" id="u_pass" name="u_pass" value="">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="re_pass">重复密码</label>
						<div class="controls">
						  	<input type="password" id="re_pass" name="re_pass">
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="user_commit" data-act="%url%">修改</a>
				</div></fieldset></form>';
				$user_info = M("admin")->where("id='{$id}'")->find();
				echo str_replace(array("%id%", "%name%", "%url%"), array($user_info['id'], $user_info['name'], __URL__."/userEdit"), $responseHTML);
			}
		}
	}
	/** 编辑用户角色 **/
	public function userEditRole(){
		if(per_check("admin_edit")&&$_POST['id']!="1"){
			$data = array(
				"id" 	=> stripslashes(trim($_POST['id'])),
				"role"	=> stripslashes(trim($_POST['value']))
			);
			if(M("admin")->save($data)){
				$user_info = M("admin")->join("zt_role ON role=role_id")->where("id={$data['id']}")->find();
				$this->watchdog("编辑", "更改用户{$user_info['name']}的角色为{$user_info['role_name']}");
				echo "ok";
			}else{
				echo "fail";
			}
		}else{
			echo "denied";
		}
	}
	/* 删除用户 */
	public function userDel($chkt=""){
		if(empty($chkt)){
			$msg = response_msg("INVALID_ARGUMENT");
		}else{
			if(!per_check("admin_delete")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				if(is_array($chkt)){
					$map['id'] = array("in", $chkt);
				}else{
					$map['id'] = $chkt;
				}
				$users = M("admin")->where($map)->getField("name", true);
				if(M("admin")->where($map)->delete()){
					$this->watchdog("删除", "删除系统用户 ".implode(",", $users));
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}
		}
		redirect(__URL__."/users/msg/{$msg}");
	}
	/* 添加用户 */
	public function userAdd($action=""){
		if($action=="add"){
			if(!per_check("user_add")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$user = M("admin");
				$data = $user->create();
				$data['pass'] = md5($_POST['u_pass']);
				$data['addtime'] = time();
				$data['creator'] = $_SESSION['user'];
				$count = $user->where("name='{$data[name]}'")->count();
				if($count>0){
					$msg = $msg = response_msg("ADD_EXIST");
				}elseif($u_id = $user->add($data)){
					$newUser = $user->join(" zt_role ON role=role_id")->where("id={$u_id}")->find();
					$detail = "添加了角色为%role%的新用户%name%";
					$this->watchdog("新增", str_replace(array("%role%", "%name%"), array($newUser['role_name'], $newUser['name']), $detail));
					$msg = $msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = $msg = response_msg("OPERATION_FAILED");
				}
			}
			redirect(__URL__."/users/msg/{$msg}");
		}else{
			if(!per_check("user_add")){
				echo response_msg("操作受限!", "error", true);exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal"><fieldset>
				<input type="hidden" name="action" value="add" />	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加用户</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="name">用户名</label>
						<div class="controls">
							 <input type="text" id="name" name="name">
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="u_pass">登录密码</label>
						<div class="controls">
						  	<input type="password" id="u_pass" name="u_pass">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="re_pass">重复密码</label>
						<div class="controls">
						  	<input type="password" id="re_pass" name="re_pass">
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="role">用户角色</label>
						<div class="controls">
							 <select id="u_role" name="role" data-rel="chosen">
								%options%
							 </select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="user_commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			$roles = M("role")->getField("role_id,role_name");
			$options = "";
			foreach($roles as $k=>$v){
				$options .= "<option value='{$k}'>{$v}</option>";
			}
			$url = __URL__."/userAdd";
			echo str_replace(array("%options%","%url%"), array($options, __ACTION__), $responseHTML);
		}
	}
	
	/* 系统日志 */
	public function logs(){
		$log = M("log");
		$param = array();
		$map = array();
		if(isset($_REQUEST['log_action']) && $_REQUEST['log_action'] != "all"){
			$map['log_action'] = $_REQUEST['log_action'];
			$param['log_action'] = $_REQUEST['log_action'];
		}
		if(isset($_REQUEST['words'])){
			$word = strip_tags($_REQUEST['words']);
			if(strlen($word)>=3){
				$map['log_detail'] = array("like", "%{$word}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		// total
		$total = $log->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 16, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//查询结果
		$order = "log_time DESC";
		$logs = $log->where($map)->order($order)->limit($limit)->select();
		$this->assign("logs", $logs);
		$actions = $log->group("log_action")->getField("log_action,log_action action", true);
		$this->assign("actions", $actions);
		$this->display();
	}
	/* 权限列表 */
	public function permissions(){
		$per = M("purview");
		$pers = $per->select();
		$roles = M("role")->select();
		foreach($roles as $v){
			$role_pers[$v['role_name']] = explode(",", $v['role_purview']);
		}
		foreach($pers as $k=>$v){
			foreach($role_pers as $key=>$val){
				if(in_array("all",$val) || in_array($v['per_id'], $val)){
					$v[$key] = "checked='checked'";
				}else{
					$v[$key] = "";
				}
			}
			$pers_grp[$v['per_group']][] = $v;
			
		}
		$this->assign("pers_grp", $pers_grp);
		$this->assign("roles", $roles);
		$this->display();
		
	}
	/* 修改权限 */
	public function permission_edit(){
		if(!per_check("per_edit")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/permissions/msg/{$msg}");
		}else{
			foreach($_POST as $k=>$v){
				if(strpos("per_", $k)==0){
					$data['role_id'] = substr($k, 4, 1);
					$data['role_purview'] = implode(",", $v);
				}
				M("role")->save($data);
			}
			$this->watchdog("编辑", "编辑角色权限");
			redirect(__URL__."/permissions");
		}
	}
	
	/**
	 * 数据备份管理
	 */
	public function sql_data(){
		$param = array();
		$map = array();
		if(isset($_REQUEST['words'])){
			$word = strip_tags($_REQUEST['words']);
			if(strlen($word)>=2){
				$filekey = $word;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		// total
		if(is_dir("./data/")){
			$d = opendir("./data/");
			while (false !== ($filename = readdir($d))) {
    			if($filename=="."||$filename==".."){
    				continue;
    			}
    			if(isset($filekey)){
    				if(strpos($filekey, $filename)<0){
    					continue;
    				}
    			}
    			$files[] = array(
    				'name' => $filename,
    				'time' => date("Y-m-d H:i:s",filectime("./data/".$filename)),
    				'size' => round(filesize("./data/".$filename)/1024)." Kb"
    			);
			}
			closedir($d);
			$total = count($files);
			import("Org.Util.Page");
			$page = new Page($total, 16, $param);
			// 分页查询
			$start = $page->firstRow;
			$end = ($start+$page->listRows)>$total ? $total : ($start+$page->listRows);
			$this->assign("start", $start);
			$this->assign("end", $end);
			$pager = $page->shown();
			$this->assign("pager", $pager);
			$this->assign("files", $files);
			$this->display();
		}else{
			echo "./data/不存在";
		}	
	}
	/**
	 * 下载数据备份sql
	 */
	public function sql_data_download($filename=""){
		if($filename){
			if(!per_check("sql_backup")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$filename = substr($filename, -4, 4)=='.sql' ? $filename : $filename.".sql";
				$file = $_SERVER['DOCUMENT_ROOT'].__ROOT__."/data/".$filename;
				if(!file_exists($file)){
					$msg = response_msg("FILE_NOT_EXIST");
				}else{
					import("ORG.Net.Http");
					$down = new Http();
					if(!$down->download($file)) {
						$msg = response_msg("OPERATION_SUCCESS");
					}else{
						$msg = response_msg("OPERATION_FAILED", "success");
					}
				}
			}
		}else{
			$msg = response_msg("INVALID_ARGUMENT");
		}
		redirect(__URL__."/sql_data/msg/{$msg}");
	}
	/**
	 * 删除数据备份sql文件
	 * @param string $chkt
	 */
	public function sql_data_delete($chkt=""){
		if(!per_check("sql_delete")){
			$this->error('无此权限！');
		}else{
			if(!is_array($chkt)){
				$chkt = array($chkt);
			}
			$result = 0;
			foreach($chkt as $f){
				$file = $_SERVER['DOCUMENT_ROOT'].__ROOT__.'/data/'.(strpos($f, "sql") ? $f : $f.'.sql');
				if(!unlink($file)){
					++$result;
				}
			}
			if($result>0){
				$this->error('删除失败！');
			}else{
				$this->success('删除成功！');
			}
		}
	}
	/**
	 * 数据库备份
	 */
	public function backup(){
		if(!per_check("sql_backup")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$host = C("DB_HOST").":".C('DB_PORT');
			$user = C("DB_USER");
			$pass = C("DB_PWD");
			$dbname = C("DB_NAME");
			if (!mysql_connect($host, $user, $pass)){
			    $msg = response_msg('MYSQL_CONNECT_FAILED');
			}else{
				if (!mysql_select_db($dbname)){
				    echo '不存在数据库:' . $dbname . ',请核对后再试';
				    exit;
				}
				mysql_query("set names 'utf8'");
				$mysql = "set charset utf8;\r\n";
				$q1 = mysql_query("show tables");
				while ($t = mysql_fetch_array($q1)){
					$table = $t[0];
					$q2 = mysql_query("show create table `$table`");
					$sql = mysql_fetch_array($q2);
					$mysql .= $sql['Create Table'] . ";\r\n";
					$q3 = mysql_query("select * from `$table`");
					while ($data = mysql_fetch_assoc($q3)){
						$keys = array_keys($data);
						$keys = array_map('addslashes', $keys);
						$keys = join('`,`', $keys);
						$keys = "`" . $keys . "`";
						$vals = array_values($data);
						$vals = array_map('addslashes', $vals);
						$vals = join("','", $vals);
						$vals = "'" . $vals . "'";
						$mysql .= "insert into `$table`($keys) values($vals);\r\n";
					}
				}
				$filename = "./data/".$dbname . date('YmjHis') . ".sql"; //存放路径，默认存放到项目最外层
				$fp = fopen($filename, 'w');
				fputs($fp, $mysql);
				fclose($fp);
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}
		}
		redirect(__URL__."/sql_data/msg/{$msg}");
	}
	
	
	
}