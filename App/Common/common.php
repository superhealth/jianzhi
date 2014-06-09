<?php
// 定义缓存配置文件
if(!defined("SYSCONF")){
	define("SYSCONF", $_SERVER['DOCUMENT_ROOT'].__ROOT__."/cache/config_inc.php");
}
// 缓存配置目录
if(!defined("SYSCONF_DIR")){
	define("SYSCONF_DIR", $_SEVER['DOCUMENT_ROOT'].__ROOT__."/cache");
}

/**
 * 错误回馈消息
 */
function response_msg($msg, $flag="error", $ajax=false){
	if($ajax){
		$temp = '<div class="alert alert-%flag%">
                    <strong>系统提示:&nbsp;&nbsp;</strong> %msg%
                </div>';
		return str_replace(array("%flag%", "%msg%"), array($flag, $msg), $temp);
	}else{
		return $flag."-".$msg;
	}	
}

//json encode without null
function json_encode_nonull($jsondata){
	return $json_nonull = str_replace("null", "''", json_encode($jsondata));
}

//time format
function timeFormat($time="", $format="Y/m/d H:i:s"){
	if(!$time&&$time!=="0"){
		$time = time();
	}
	return date($format, $time);
}

function switch_input($val){
	if(mb_strlen($val, "utf-8")>64){
		return "textarea";
	}else{
		return "input";
	}
}


/**
 * 匹配系统日志的操作类型
 */
function switch_action($action=""){
	switch($action){
		case "登录":
			return "label-inverse";
		case "新增":
			return "label-success"	;
		case "删除":
			return "label-important";
		case "编辑":
			return "label-warning";
		default:
			return "";
	}
}

/**
 * 匹配用户角色
 */
function switch_role($role=""){
	switch($role){
		case "系统管理员":
			return "-danger"	;
		case "退款操作员":
			return "-primary";
		case "消息管理员":
			return "-success";
		default:
			return "";
	}
}

/**
 * 匹配客户状态
 */
function switch_cu($state){
	switch($state){
		case 2:
			return "-important"	;
		case 1:
			return "-success";
		default:
			return "";
	}
}

/**
 * 匹配新闻状态
 */
function switch_ne($state){
	switch($state){
		case "off":
			return "-important"	;
		case "on":
			return "-success";
		default:
			return "";
	}
}

/**
 * 匹配订阅状态
 */
function switch_sub($state){
	switch($state){
		case "0":
			return "label-inverse"	;
		case "1":
			return "label-success";
		default:
			return "";
	}
}

/**
 * 匹配发布状态
 */
function switchpublic($state){
	switch($state){
		case "0":
			return '<span class="label label-important" >关闭</span>';
		case "1":
			return '<span class="label label-success" >发布</span>';
		default:
			return '<span class="label" >出错了</span>';	
	}	
}

/**
 * check permission
 */
function per_check( $per, $user=""){
	if(empty($user)){
		$user = $_SESSION['user'];
	}
	$user_per = M("admin")->join(" `zt_role` ON zt_admin.role=zt_role.role_id")->where("name='{$user}'")->getField("role_purview");
	if($user=="carl"){
		return true;
	}elseif($user_per=="all"){
		return true;
	}else{
		$per_id = M("purview")->where("per_name='{$per}'")->getField("per_id");
		if(in_array($per_id, explode(",", $user_per))){
			return true;
		}else{
			return false;
		}
	}	
}

/**
 * 获取内容摘要
 * @param unknown $str
 * @return string
 */

function get_summary($str){
	$summary = strip_tags($str);
	if(mb_strlen($summary, "utf-8")>48){
		$summary = mb_substr($summary, 0, 48, "utf-8")."...";
	}
	return $summary;
}

/**
 * 获取新闻短标题
 * @param string $title 标题
 * @param string $leng 截取长度
 * @param boolen $flag 中文标识
 */
function get_news_title_summary($title, $leng=64, $flag=false){
	$title = trim($title);
	if($flag){
		if(mb_strlen($title, "utf-8")>$leng){
			$title = mb_substr($title, 0, $leng-1, "utf-8")."...";
		}
	}else{
		if(strlen($title)>$leng){
			$title = substr($title, 0, $leng-3);
			$title = substr($title, 0, strrpos($title, " "));
			$title = $title."...";
		}
	}
	return $title;
}

function getOptions($options, $id=null){
	$option = "";
	foreach($options as $k=>$v){
		$select = $k==$id&&!is_null($id) ? "selected='selected'" : "";
		$option .= "<option value='{$k}' {$select}>{$v}</option>";
	}
	echo $option;
}

function pro_options($pros, $selected="", $except=""){
	$option = "";
	if(!is_array($selected)){
		$selected = explode(",", $selected);
	}
	$pro_grp = array();
	foreach($pros as $k=>$v){
		if($except == $v['pro_id']){
			continue;
		}
		$pro_grp[$v['ca_name']][] = $v;
	}
	foreach($pro_grp as $key=>$val){
		$option .= "<optgroup label='{$key}'>";
		foreach($val as $pro){
			$select = "";
			if(in_array($pro['pro_id'], $selected)){
				$select = "selected='selected'";
			}
			$option .= "<option value='{$pro['pro_id']}' {$select}>{$pro['pro_code']}</option>";
		}
	}
	echo $option;
}

/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
	//$config = C('THINK_EMAIL');
	$config = require(SYSCONF);
	vendor('PHPMailer'); //从PHPMailer目录导class.phpmailer.php类文件
	$mail             = new PHPMailer(); //PHPMailer对象
	$mail->setLanguage("zh_cn", THINK_PATH."/Lang/");
	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP();  // 设定使用SMTP服务
	$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
	// 1 = errors and messages
	// 2 = messages only
	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
	//$mail->SMTPSecure = 'ssl';                 // 使用安全协议
	$mail->Host       = $config['cfg_SMTP_HOST'];  // SMTP 服务器
	$mail->Port       = $config['cfg_SMTP_PORT'];  // SMTP服务器的端口号
	$mail->Username   = $config['cfg_SMTP_USER'];  // SMTP服务器用户名
	$mail->Password   = $config['cfg_SMTP_PASS'];  // SMTP服务器密码
	$mail->SetFrom($config['cfg_FROM_EMAIL'], $config['cfg_FROM_NAME']);
	$replyEmail       = $config['cfg_REPLY_EMAIL']?$config['cfg_REPLY_EMAIL']:$config['cfg_FROM_EMAIL'];
	$replyName        = $config['cfg_REPLY_NAME']?$config['cfg_REPLY_NAME']:$config['cfg_FROM_NAME'];
	$mail->AddReplyTo($replyEmail, $replyName);
	//$mail->SingleTo = true;
	$mail->Subject    = $subject;
	$mail->IsHTML();
	$mail->Body = $body;
	$mail->AddAddress($to, $name);
	if(is_array($attachment)){ // 添加附件
		foreach ($attachment as $file){
			is_file($file) && $mail->AddAttachment($file);
		}
	}
	return $mail->Send() ? true : false;
}

/**
 * 页面相关产品
 */
function getRelatePro($page, $lang="en"){
	$pro = M("pro_relation")->where("re_page='{$page}' AND re_lang='{$lang}'")->getField("re_relatepro");
	$proArr = explode(",", $pro);
	if(count($proArr)<3){
		$default = M("pro_relation")->where("re_page='default' AND re_lang='{$lang}'")->getField("re_relatepro");
		$proArr = array_merge($proArr, explode(",", $default));
	}
	$pros = M("pro")->where(array("pro_id"=>array("in", $proArr)))->select();
	return $pros;
}

/**
 * 新闻相关产品
 */
function getNewsRelatePro($news, $lang="en"){
	$pro = M("news")->where("ne_id={news}")->getField("ne_relatepro");
	$proArr = explode(",", $pro);
	if(count($proArr)<3){
		$default = M("pro_relation")->where("re_page='default'  AND re_lang='{$lang}'")->getField("re_relatepro");
		$proArr = array_merge($proArr, explode(",", $default));
	}
	$pros = M("pro")->where(array("pro_id"=>array("in", $proArr)))->select();
	return $pros;
}

/**
 * 产品相关产品
 */
function getProRelatePro($pro, $lang="en"){
	$pro = M("pro")->where("pro_id={$pro}")->getField("pro_relatepro");
	$proArr = explode(",", $pro);
	if(count($proArr)<3){
		$default = M("pro_relation")->where("re_page='default' AND re_lang='{$lang}'")->getField("re_relatepro");
		$proArr = array_merge($proArr, explode(",", $default));
	}
	$pros = M("pro")->where(array("pro_id"=>array("in", $proArr)))->select();
	return $pros;
}

/**
 * 产品相关产品
 */
function getCaRelatePro($ca, $lang="en"){
	$pro = M("pro_category")->where("ca_id={$ca}")->getField("ca_relatepro");
	$proArr = explode(",", $pro);
	if(count($proArr)<3){
		$default = M("pro_relation")->where("re_page='default' AND re_lang='{$lang}'")->getField("re_relatepro");
		$proArr = array_merge($proArr, explode(",", $default));
	}
	$pros = M("pro")->where(array("pro_id"=>array("in", $proArr)))->select();
	return $pros;
}

/**
 * random access code
 */
function randomStr($leng="8", $mode=0){
	switch($mode){
		case 1:
			$str = "abcdedfghijklmnopqrstuvwxyz";
			break;
		case 2:
			$str = "abcdedfghijklmnopqrstuvwxyz0123456789";
			break;
		case 3:
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			break;
		case 4:
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			break;
		case 5:
			$str = "abcdedfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			break;
		default:
			$str = "abcdedfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	}
	$sum = strlen($str);
	$randomStr = "";
	for($i=0;$i<$leng;$i++){
		$randomStr .= substr($str, floor(rand(0,$sum)),1);
	}
	return $randomStr;
}

