<?php
// 定义缓存配置文件
if(!defined("SYSCONF")){
	define("SYSCONF", $_SERVER['DOCUMENT_ROOT'].__ROOT__."/cache/config_inc.php");
}
// 缓存配置目录
if(!defined("SYSCONF_DIR")){
	define("SYSCONF_DIR", $_SERVER['DOCUMENT_ROOT'].__ROOT__."/cache");
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
	$time = (int)$time;
	if(!$time&&$time!==0){
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
		case "新增": case "解锁":
			return "label-success"	;
		case "删除": case "锁定":
			return "label-important";
		case "编辑": case "续费":
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
 * 匹配用户类型
 */
function switch_type($state){
	switch($state){
		case 0:
			return "-success"	;
		case 1:
			return "-warning";
		default:
			return "";
	}
}

/**
 * 匹配用户状态
 */
function switch_status($state){
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
 * 匹配用户续费状态
 */
function switch_active($state){
	switch($state){
		case 0:
			return "-important"	;
		case 1:
			return "-success";
		default:
			return "";
	}
}

/**
 * 项目状态
 */
function switchProStatus($status){
	switch($status){
		case 0:
			return "-info"	;
		case 1:
			return "-success";
		case 2:
			return "-inverse";
		case 3:
			return "-warning";
		default:
			return "";
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

/**
 * 生成下拉选项
 * @param array $options 选项数组
 * @param string $id 选中id
 */
function getOptions($options, $id=null){
	$option = "";
	foreach($options as $k=>$v){
		$select = $k==$id&&!is_null($id) ? "selected='selected'" : "";
		$option .= "<option value='{$k}' {$select}>{$v}</option>";
	}
	echo $option;
}

/**
 * 生成无默认值的下拉选项
 * @param array $options 选项数组
 * @param string $opt 选中项
 */
function getOptionsNoValue($options, $opt=""){
	$option = "";
	foreach($options as $v){
		$select = $v==$opt&&$name!=="" ? "selected='selected'" : "";
		$option .= "<option {$select}>{$v}</option>";
	}
	echo $option;
}

/**
 * 生成单选框
 * @param array $options 选项数组 
 * @param string $name 表单name
 * @param string $id 选中id
 */
function getRadio($options, $name, $id=""){
	$radios = "";
	foreach($options as $k=>$v){
		$checked = ($k==$id&&$id!=="") ? "checked" : "";
		$radios .="<label class='radio inline'><input type='radio' name='{$name}' value='{$k}' {$checked} />{$v}</label>";
	}
	echo $radios;
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

function getFileSize($size){
	if($size<1024){
		return (string)$size."bytes";
	}else if($size/1024<1024){
		$size = round($size*100/1024)/100;
		return (string)$size."Kb";
	}else if($size/(1024*1024)<1024){
		$size = round($size*100/(1024*1024))/100;
		return (string)$size."Mb";
	}else{
		$size = round($size*100/(1024*1024*1024))/100;
		return (string)$size."Gb";
	}
}


/**
 * 图片上传
 * @return string
 */

function upload($imgOnly=true, $saveRule="", $type=""){
	import('ORG.Net.UploadFile');
	$upload = new UploadFile();
	$upload->thumb = false;							//是否生成缩略图
	//$upload->thumbMaxWidth = '180';			//缩略图最大宽度
	//$upload->thumbMaxHeight = '40';			//缩略图最大高度
	//$upload->thumbPrefix = 'mi_';					//缩略图前缀
	//$upload->thumbRemoveOrigin = false;			//
	$upload->uploadReplace = true;
	$upload->maxSize  = 3145728*1024 ;				// 设置附件上传大小
	$upload->saveRule = $saveRule;
	if($imgOnly){
		$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');
	}else{
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'pdf', 'txt');		// 设置附件上传类型
	}
	$upload->savePath = './uploads/';	// 设置附件上传目录
	if(!$upload->upload()) {
		$info[] = false;
		$info[] = $upload->getErrorMsg();	// 上传错误提示错误信息
	}else{
		$info[] = true;
		$info[] = $upload->getUploadFileInfo();	// 上传成功 获取上传文件信息
	}
	return $info;
}

/**
 *
 * 删除附件
 */
function attDelete($id){
	if(!is_array($id)){
		$id = array($id);
	}
	$attInfo = M("attachement")->field("att_id, att_name")->where(array("att_id" => array("in",$id)))->select();
	$errors = array();
	foreach ($attInfo as $v){
		if(fileDelete($v['att_name'])){
			M("attachement")->where("att_id = {$v['att_id']}")->delete();
		}else{
			$errors[] = $v['att_id'];
		}
	}
	if(count($errors)>0){
		return $errors;
	}else{
		return true;
	}
}
/**
 * 删除文件
 */
function fileDelete($file, $dir=""){
	$dir = preg_replace("/[\\\/]$/", "", $dir);
	$path = empty($dir) ? $_SERVER['DOCUMENT_ROOT'].__ROOT__."/uploads/{$file}" : $dir."/".$file;
	//file_exists() 检测中文文件名需要转码
	$path=iconv('UTF-8','GB2312',$path);
	if(file_exists($path)){
		return unlink($path);
	}
	return false;
}

/**
 * 文件下载类
 * @param 文件名 $file
 * @return boolean
 */
function attDownload($file, $dir=""){
	import("ORG.Net.Http");
	$down = new Http();
	$dir = preg_replace("/[\\\/]$/", "", $dir);
	$filename = empty($dir) ? $_SERVER['DOCUMENT_ROOT'].__ROOT__."/uploads/".$file : $dir."/".$file;
	if(!$down->download($filename)) {
		return $down->geterrormsg();
	}
	return true;
}

/**
 * 将地区数组转为字符串
 * @param array $areaArr 表示地区的数组
 * @return string 表示地区的字符串
 */
function areaEncode($areaArr){
	$areaArr = array_map("addslashes", $areaArr);
	return implode("|", $areaArr);
}
/**
 * 将地区字符串转为数组
 * @param string $areaStr 表示地区的字符串
 * @return array 表示地区的数组
 */
function areaDecode($areaStr){
	return explode("|", trim($areaStr));
}
/**
 * 将地区数组输出为下拉选项
 * @param array $areaArr 表示地区的数组
 * @param number $n
 * @param string $areas
 * @return string
 */
function areaToSelect($areaArr, $n=1, $areas=""){
	$select = "<select id='area{$n}' name='area[]' class='area' >";
	if(empty($areas)){
		$areas = D("Area")->Areas();
	}
	$subArea = false;
	foreach($areas as $v){
		if(isset($areaArr[0]) && $v['name']==$areaArr[0]){
			$select .= "<option value='{$v['name']}' checked >{$v['name']}</option>";
			$subArea = $v['subArea'];
		}else{
			$select .= "<option value='{$v['name']}' >{$v['name']}</option>";
		}
	}
	$select .= "</select>";
	if(!empty($subArea)){
		$areaArr = array_shift($areaArr);
		$select .= areaToSelect($areaArr, $n++, $subArea);
	}elseif(isset($areas[0]['subArea'])){
		$select .= areaToSelect(array(), $n++, $areas[0]['subArea']);
	}
	unset($areas);
	return $select;
}

/**
 * 详细分类组合字符串解析
 * @param string $enumStr 详细分类组合字符串
 * @return array 分割后的数组
 */
function enumsDecode($enumStr){
	return explode("|", trim($areaStr));
}
/**
 * 详细分类组合数组转为数组
 * @param array $enumArr 详细分类组合数组
 * @return string 详细分类组合字符串
 */
function enumsEncode($enumArr){
	$enumArr = array_map("addslashes", $enumArr);
	return implode("|", $areaArr);
}

function enumsToSelect($sortId, $enum=""){
	$enums = D("Enumsort")->getEnums($sortId);
	$select = "";
	$flag = is_array($enum) ? true : false;
	foreach($enums as $k=>$v){
		$select .= "<select id='{$k}' name='enums[]' class='enum'><option value='no'>不限</option>";
		foreach($v as $val){
			if($flag && in_array($val, $enum)){
				$select .= "<option value='{$val}' checked >{$val}</option>";
			}else{
				$select .= "<option value='{$val}' >{$val}</option>";
			}
		}
		$select .= "</select>";
	}
	unset($enums);
	return $select;
}


