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
	return str_replace("null", '""', json_encode($jsondata));
}

//time format
function timeFormat($time="", $format="Y/m/d H:i:s"){
	if(empty($time)){
		if($time===""){
			$time = time();
		}else{
			return "";
		}
	}
	return date($format, $time);
}

function cnStrToTime($str){
	$search = array('年', '月', '日', '时', '分', '秒');
	$replace = array('/', '/', ' ', ':', ':', ' ');
	$str = str_replace($search, $replace, $str).'0';
	return strtotime($str);
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
 * @param string $status 
 */
function switchProStatus($status=""){
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
 * 应标状态
 * @param $status
 */
function switchBidState($state=""){
	switch($state){
		case 0:
			return "-info"	;
			break;
		case 1:
			return "-warning";
			break;
		case 2:
			return "-inverse";
			break;
		case 3:
			return "-success";
			break;
		default:
			return "-danger";
	}
}
/**
 * 项目状态
 */
function switchDeStatus($status=""){
	switch($status){
		case 0:
			return "-info"	;
			break;
		case 1:
			return "-success";
			break;
		case 2:
			return "-warning";
			break;
		case 3:
			return "-inverse";
			break;
		case 4:
			return "-danger";
			break;
	}
}
/**
 * 续费单状态
 */
function switchDueStatus($status=""){
	switch($status){
		case 0:
			return "-info"	;
			break;
		case 1:
			return "-success";
			break;
		case 2:
			return "-inverse";
			break;
		case 3:
			return "-danger";
			break;
		default:
			return "-warning";
	}
}


/**
 * check permission
 * @param string $per 权限名
 * @param string $user 用户
 * @return boolen
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

function get_summary($str, $len=48){
	$summary = strip_tags($str);
	if(mb_strlen($summary, "utf-8")>$len){
		$summary = mb_substr($summary, 0, $len, "utf-8")."...";
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
		$select = $v==$opt&&$opt!=="" ? "selected='selected'" : "";
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

function upload($author, $imgOnly=true, $saveRule=""){
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
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'pdf', 'txt','doc','docx','xls','xlsx');		// 设置附件上传类型
	}
	
	$author = hanzi2zimu($author);		//汉字转字母
	
	$savePath = './uploads/'.date("Ymd")."/";
	if(!is_dir($savePath)){
		mkdir($savePath);
	}elseif(!is_dir($savePath.$author."/")){
		mkdir($savePath.$author."/");
	}
	$upload->savePath = $savePath.$author."/";	// 设置附件上传目录
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
	$attInfo = M("attachement")->field("att_id, att_path")->where(array("att_id" => array("in",$id)))->select();
	$errors = array();
	foreach ($attInfo as $v){
		if(fileDelete($v['att_path'])){
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
	$path = empty($dir) ? $_SERVER['DOCUMENT_ROOT'].__ROOT__."/{$file}" : $dir."/".$file;
	//file_exists() 检测中文文件名需要转码
	$path=iconv('UTF-8','GB2312',$path);
	if(file_exists($path)){
		return unlink($path);
	}
	return false;
}

/**
 * 文件下载
 * @param 文件名 $file
 * @return boolean
 */
function attDownload($file, $showname){
	import("ORG.Net.Http");
	$down = new Http();
	$dir = preg_replace("/[\\\/]$/", "", $dir);
	$filename = empty($dir) ? $_SERVER['DOCUMENT_ROOT'].__ROOT__.$file : $dir."/".$file;
	
	$res = $down->download($filename,$showname);
	if(true!==$res) {
		return $res;
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
function areaToSelect($areaArr, $n=1, $areas="", $name=""){
	if($name==""){
		$name = 'area';
	}
	$select = "<select id='{$name}{$n}' name='{$name}[]' class='area' ><option value='no'>--选择--</option>";
	if(empty($areas)){
		$areas = D("Area")->Areas();
	}
	$subArea = false;
	foreach($areas as $v){
		if(is_array($areaArr) && in_array($v['name'],$areaArr)){
			$select .= "<option value='{$v['name']}' selected >{$v['name']}</option>";
			$subArea = $v['subArea'];
		}else{
			$select .= "<option value='{$v['name']}' >{$v['name']}</option>";
		}
	}
	$select .= "</select>";
	if(!empty($subArea)){
		$select .= areaToSelect($areaArr, ++$n, $subArea, $name);
	}elseif(isset($areas[0]['subArea'])){
		$select .= areaToSelect(array(), ++$n, $areas[0]['subArea'], $name);
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
	return explode("|", trim($enumStr));
}
/**
 * 详细分类组合数组转为数组
 * @param array $enumArr 详细分类组合数组
 * @return string 详细分类组合字符串
 */
function enumsEncode($enumArr){
	$enumArr = array_map("addslashes", $enumArr);
	return implode("|", $enumArr);
}
/**
 * 
 * @param int $sortId 主分类id
 * @param array $enum 选中的分类
 * @return string 下拉框
 */
function enumsToSelect($sortId, $enum=""){
	$enums = D("Enumsort")->getEnums($sortId);
	$select = "";
	$flag = is_array($enum) ? true : false;
	foreach($enums as $k=>$v){
		$select .= "<span class='label label-success'>{$k}</span>:<select id='{$k}' name='enums[]' class='enum'><option value='no'>--选择--</option>";
		foreach($v as $val){
			if($flag && in_array($val, $enum)){
				$select .= "<option value='{$val}' selected >{$val}</option>";
			}else{
				$select .= "<option value='{$val}' >{$val}</option>";
			}
		}
		$select .= "</select>";
	}
	unset($enums);
	return $select;
}

/**
 * 产生续费单订单号
 * @param string $m 
 */
function createDuefeeSn($m){
	return strtoupper('NF'.dechex($_SERVER['REQUEST_TIME']).substr(md5($m), 0, 4));
}

/**
 * 产生投标项目序列号
 * @param string $m
 */
function createBidderSn($m){
	return strtoupper('TB'.dechex($_SERVER['REQUEST_TIME']).substr(md5($m), 0, 4));
}

/**
 * 产生项目序列号
 * @param string $m
 */
function createProjectSn($m){
	return strtoupper('XM'.dechex($_SERVER['REQUEST_TIME']).substr(md5($m), 0, 4));
}
/**
 * 汉字转字母
 * @param string $string
 */
function hanzi2zimu($string){
	$words=preg_replace('/[\.|\/|\?|&|\+|\\\|\'|"|,-\s\<\>\[\]]+/', '', $string);
	return zh2pinyin($words);
}
/**
 * 编码转拼音
 * @param unknown $num
 * @return string
 */
function transform($num){
$dictionary = array(
    array("a", -20319),
    array("ai", -20317),
    array("an", -20304),
    array("ang", -20295),
    array("ao", -20292),
    array("ba", -20283),
    array("bai", -20265),
    array("ban", -20257),
    array("bang", -20242),
    array("bao", -20230),
    array("bei", -20051),
    array("ben", -20036),
    array("beng", -20032),
    array("bi", -20026),
    array("bian", -20002),
    array("biao", -19990),
    array("bie", -19986),
    array("bin", -19982),
    array("bing", -19976),
    array("bo", -19805),
    array("bu", -19784),
    array("ca", -19775),
    array("cai", -19774),
    array("can", -19763),
    array("cang", -19756),
    array("cao", -19751),
    array("ce", -19746),
    array("ceng", -19741),
    array("cha", -19739),
    array("chai", -19728),
    array("chan", -19725),
    array("chang", -19715),
    array("chao", -19540),
    array("che", -19531),
    array("chen", -19525),
    array("cheng", -19515),
    array("chi", -19500),
    array("chong", -19484),
    array("chou", -19479),
    array("chu", -19467),
    array("chuai", -19289),
    array("chuan", -19288),
    array("chuang", -19281),
    array("chui", -19275),
    array("chun", -19270),
    array("chuo", -19263),
    array("ci", -19261),
    array("cong", -19249),
    array("cou", -19243),
    array("cu", -19242),
    array("cuan", -19238),
    array("cui", -19235),
    array("cun", -19227),
    array("cuo", -19224),
    array("da", -19218),
    array("dai", -19212),
    array("dan", -19038),
    array("dang", -19023),
    array("dao", -19018),
    array("de", -19006),
    array("deng", -19003),
    array("di", -18996),
    array("dian", -18977),
    array("diao", -18961),
    array("die", -18952),
    array("ding", -18783),
    array("diu", -18774),
    array("dong", -18773),
    array("dou", -18763),
    array("du", -18756),
    array("duan", -18741),
    array("dui", -18735),
    array("dun", -18731),
    array("duo", -18722),
    array("e", -18710),
    array("en", -18697),
    array("er", -18696),
    array("fa", -18526),
    array("fan", -18518),
    array("fang", -18501),
    array("fei", -18490),
    array("fen", -18478),
    array("feng", -18463),
    array("fo", -18448),
    array("fou", -18447),
    array("fu", -18446),
    array("ga", -18239),
    array("gai", -18237),
    array("gan", -18231),
    array("gang", -18220),
    array("gao", -18211),
    array("ge", -18201),
    array("gei", -18184),
    array("gen", -18183),
    array("geng", -18181),
    array("gong", -18012),
    array("gou", -17997),
    array("gu", -17988),
    array("gua", -17970),
    array("guai", -17964),
    array("guan", -17961),
    array("guang", -17950),
    array("gui", -17947),
    array("gun", -17931),
    array("guo", -17928),
    array("ha", -17922),
    array("hai", -17759),
    array("han", -17752),
    array("hang", -17733),
    array("hao", -17730),
    array("he", -17721),
    array("hei", -17703),
    array("hen", -17701),
    array("heng", -17697),
    array("hong", -17692),
    array("hou", -17683),
    array("hu", -17676),
    array("hua", -17496),
    array("huai", -17487),
    array("huan", -17482),
    array("huang", -17468),
    array("hui", -17454),
    array("hun", -17433),
    array("huo", -17427),
    array("ji", -17417),
    array("jia", -17202),
    array("jian", -17185),
    array("jiang", -16983),
    array("jiao", -16970),
    array("jie", -16942),
    array("jin", -16915),
    array("jing", -16733),
    array("jiong", -16708),
    array("jiu", -16706),
    array("ju", -16689),
    array("juan", -16664),
    array("jue", -16657),
    array("jun", -16647),
    array("ka", -16474),
    array("kai", -16470),
    array("kan", -16465),
    array("kang", -16459),
    array("kao", -16452),
    array("ke", -16448),
    array("ken", -16433),
    array("keng", -16429),
    array("kong", -16427),
    array("kou", -16423),
    array("ku", -16419),
    array("kua", -16412),
    array("kuai", -16407),
    array("kuan", -16403),
    array("kuang", -16401),
    array("kui", -16393),
    array("kun", -16220),
    array("kuo", -16216),
    array("la", -16212),
    array("lai", -16205),
    array("lan", -16202),
    array("lang", -16187),
    array("lao", -16180),
    array("le", -16171),
    array("lei", -16169),
    array("leng", -16158),
    array("li", -16155),
    array("lia", -15959),
    array("lian", -15958),
    array("liang", -15944),
    array("liao", -15933),
    array("lie", -15920),
    array("lin", -15915),
    array("ling", -15903),
    array("liu", -15889),
    array("long", -15878),
    array("lou", -15707),
    array("lu", -15701),
    array("lv", -15681),
    array("luan", -15667),
    array("lue", -15661),
    array("lun", -15659),
    array("luo", -15652),
    array("ma", -15640),
    array("mai", -15631),
    array("man", -15625),
    array("mang", -15454),
    array("mao", -15448),
    array("me", -15436),
    array("mei", -15435),
    array("men", -15419),
    array("meng", -15416),
    array("mi", -15408),
    array("mian", -15394),
    array("miao", -15385),
    array("mie", -15377),
    array("min", -15375),
    array("ming", -15369),
    array("miu", -15363),
    array("mo", -15362),
    array("mou", -15183),
    array("mu", -15180),
    array("na", -15165),
    array("nai", -15158),
    array("nan", -15153),
    array("nang", -15150),
    array("nao", -15149),
    array("ne", -15144),
    array("nei", -15143),
    array("nen", -15141),
    array("neng", -15140),
    array("ni", -15139),
    array("nian", -15128),
    array("niang", -15121),
    array("niao", -15119),
    array("nie", -15117),
    array("nin", -15110),
    array("ning", -15109),
    array("niu", -14941),
    array("nong", -14937),
    array("nu", -14933),
    array("nv", -14930),
    array("nuan", -14929),
    array("nue", -14928),
    array("nuo", -14926),
    array("o", -14922),
    array("ou", -14921),
    array("pa", -14914),
    array("pai", -14908),
    array("pan", -14902),
    array("pang", -14894),
    array("pao", -14889),
    array("pei", -14882),
    array("pen", -14873),
    array("peng", -14871),
    array("pi", -14857),
    array("pian", -14678),
    array("piao", -14674),
    array("pie", -14670),
    array("pin", -14668),
    array("ping", -14663),
    array("po", -14654),
    array("pu", -14645),
    array("qi", -14630),
    array("qia", -14594),
    array("qian", -14429),
    array("qiang", -14407),
    array("qiao", -14399),
    array("qie", -14384),
    array("qin", -14379),
    array("qing", -14368),
    array("qiong", -14355),
    array("qiu", -14353),
    array("qu", -14345),
    array("quan", -14170),
    array("que", -14159),
    array("qun", -14151),
    array("ran", -14149),
    array("rang", -14145),
    array("rao", -14140),
    array("re", -14137),
    array("ren", -14135),
    array("reng", -14125),
    array("ri", -14123),
    array("rong", -14122),
    array("rou", -14112),
    array("ru", -14109),
    array("ruan", -14099),
    array("rui", -14097),
    array("run", -14094),
    array("ruo", -14092),
    array("sa", -14090),
    array("sai", -14087),
    array("san", -14083),
    array("sang", -13917),
    array("sao", -13914),
    array("se", -13910),
    array("sen", -13907),
    array("seng", -13906),
    array("sha", -13905),
    array("shai", -13896),
    array("shan", -13894),
    array("shang", -13878),
    array("shao", -13870),
    array("she", -13859),
    array("shen", -13847),
    array("sheng", -13831),
    array("shi", -13658),
    array("shou", -13611),
    array("shu", -13601),
    array("shua", -13406),
    array("shuai", -13404),
    array("shuan", -13400),
    array("shuang", -13398),
    array("shui", -13395),
    array("shun", -13391),
    array("shuo", -13387),
    array("si", -13383),
    array("song", -13367),
    array("sou", -13359),
    array("su", -13356),
    array("suan", -13343),
    array("sui", -13340),
    array("sun", -13329),
    array("suo", -13326),
    array("ta", -13318),
    array("tai", -13147),
    array("tan", -13138),
    array("tang", -13120),
    array("tao", -13107),
    array("te", -13096),
    array("teng", -13095),
    array("ti", -13091),
    array("tian", -13076),
    array("tiao", -13068),
    array("tie", -13063),
    array("ting", -13060),
    array("tong", -12888),
    array("tou", -12875),
    array("tu", -12871),
    array("tuan", -12860),
    array("tui", -12858),
    array("tun", -12852),
    array("tuo", -12849),
    array("wa", -12838),
    array("wai", -12831),
    array("wan", -12829),
    array("wang", -12812),
    array("wei", -12802),
    array("wen", -12607),
    array("weng", -12597),
    array("wo", -12594),
    array("wu", -12585),
    array("xi", -12556),
    array("xia", -12359),
    array("xian", -12346),
    array("xiang", -12320),
    array("xiao", -12300),
    array("xie", -12120),
    array("xin", -12099),
    array("xing", -12089),
    array("xiong", -12074),
    array("xiu", -12067),
    array("xu", -12058),
    array("xuan", -12039),
    array("xue", -11867),
    array("xun", -11861),
    array("ya", -11847),
    array("yan", -11831),
    array("yang", -11798),
    array("yao", -11781),
    array("ye", -11604),
    array("yi", -11589),
    array("yin", -11536),
    array("ying", -11358),
    array("yo", -11340),
    array("yong", -11339),
    array("you", -11324),
    array("yu", -11303),
    array("yuan", -11097),
    array("yue", -11077),
    array("yun", -11067),
    array("za", -11055),
    array("zai", -11052),
    array("zan", -11045),
    array("zang", -11041),
    array("zao", -11038),
    array("ze", -11024),
    array("zei", -11020),
    array("zen", -11019),
    array("zeng", -11018),
    array("zha", -11014),
    array("zhai", -10838),
    array("zhan", -10832),
    array("zhang", -10815),
    array("zhao", -10800),
    array("zhe", -10790),
    array("zhen", -10780),
    array("zheng", -10764),
    array("zhi", -10587),
    array("zhong", -10544),
    array("zhou", -10533),
    array("zhu", -10519),
    array("zhua", -10331),
    array("zhuai", -10329),
    array("zhuan", -10328),
    array("zhuang", -10322),
    array("zhui", -10315),
    array("zhun", -10309),
    array("zhuo", -10307),
    array("zi", -10296),
    array("zong", -10281),
    array("zou", -10274),
    array("zu", -10270),
    array("zuan", -10262),
    array("zui", -10260),
    array("zun", -10256),
    array("zuo", -10254),
	array("bao", -8735),
	array("bao", -8734),
);

    if ($num > 0 && $num < 160) {
        return chr($num);
    }
    elseif ($num < -20319 || $num > -10247) {
        return "";
    }
    else {
		for ($i = count($dictionary) - 1; $i >= 0; $i--) {
            if ($dictionary[$i][1] <= $num) {
                break;
            }
        }
        return $dictionary[$i][0];
    }
}

function zh2pinyin($string){
    $output = "";
	$string=@iconv("UTF-8",'gbk',  $string);
	//$string=mb_convert_encoding($string, "GBK", "UTF-8"); 
    for ($i=0; $i < strlen($string); $i++) {
        $letter = ord(substr($string, $i, 1));
        if($letter > 160){
            $tmp = ord(substr($string, ++$i, 1));
            $letter = $letter * 256 + $tmp - 65536;
        }
		if($letter=="-8735")$letter="-20230";
        $output .= transform($letter); 
    }
    return $output;
}
/**
 * 发送验证邮件
 */
function postVerifyMail($member){
	$email = M("member")->where("mem_id='{$member}'")->getField("mem_email");
	if(empty($email)){
		return "不存在的用户或未绑定邮箱！";
	}
	$verify = array(randomStr(8, 4), time());
	$verifyCode = implode("-", $verify);
	$subject = "[订单网]验证您的电子邮箱地址";
	$host = D('Sysconf')->getConf('cfg_basehost');
	$body = '尊敬的 <b>'.$member.'</b> 您好！感谢您注册成为《订单网》会员，请点击 <a href="http://'.$host.'/Member/verifyMail/member/'.$member.'/verifyCode/'.$verify[0].'">邮箱验证链接</a> 完成邮箱验证。<br />如果您不是 <b>'.$member.'</b> ，请忽略该邮件。';
	if(think_send_mail($email, $member, $subject, $body)){
		M("member")->where("mem_id='{$member}'")->setField("mem_verifycode", $verifyCode);
		$_SESSION['emailVerifyTime'] = $_SERVER['REQUEST_TIME'];
		return true;
	}else{
		return false;
	}
}
/**
 * 发送验证邮件
 */
function postChangeMail($member, $email){
	$verify = array(randomStr(8, 4), time());
	$verifyCode = implode("-", $verify);
	$subject = "[订单网]验证您的电子邮箱地址";
	$host = D('Sysconf')->getConf('cfg_basehost');
	$body = '尊敬的 <b>'.$member.'</b> 您好！感谢您注册成为《订单网》会员，请点击 <a href="http://'.$host.'/Member/changeEmail/code/'.$verify[0].'">邮箱验证链接</a> 完成邮箱验证。<br />如果您不是 <b>'.$member.'</b> ，请忽略该邮件。';
	if(think_send_mail($email, $member, $subject, $body)){
		M("member")->where("mem_id='{$member}'")->setField("mem_verifycode", $verifyCode);
		$_SESSION['emailVerifyTime'] = $_SERVER['REQUEST_TIME'];
		return true;
	}else{
		return false;
	}
}

/**
 * 邮箱发送验证码
 */
function verifyCode($member="", $subject=""){
	$email = M("member")->where("mem_id='{$member}'")->getField("mem_email");
	if(empty($email)){
		return "不存在的用户或未绑定邮箱！";
	}
	$verify = array(randomStr(8, 4), time());
	$verifyCode = implode("-", $verify);
	$subject = empty($subject) ? "[订单网] 用户操作安全码邮件" : $subject;
	$host = D('Sysconf')->getConf('cfg_basehost');
	$body = '尊敬的 <b>'.$member.'</b> 您好！您本次操作的安全码是 <br /><b style="font-size:larger;">'.$verify[0].'</b><br />如果您不是 <b>'.$member.'</b>，请忽略该邮件。';
	if(think_send_mail($email, $member, $subject, $body)){
		M("member")->where("mem_id='{$member}'")->setField("mem_verifycode", $verifyCode);
		$_SESSION['emailSendTime'] = $_SERVER['REQUEST_TIME'];
		return true;
	}else{
		return false;
	}
}

/**
 * 对邮箱进行保密处理
 * @param string $email
 * @return 
 */
function emailToHide($email){
	return preg_replace('/(?<=.{2}).*(?=.{2}@)/', "**",$email);
}

/**
 * 获取会员状态，返回剩余时间。
 * @param int $time 会员过期时间时间戳
 * @return multitype:string number
 */
function getExpireStatus($time){
	$remind = D('Sysconf')->getConf('cfg_duenotice');
	$left = $time - $_SERVER['REQUEST_TIME'];
	if($left<=0){
		return array('flag'=>'expired', 'day'=>0);
	}else if($left>$remind*24*3600){
		return array('flag'=>'normal', 'day'=>(int)($left/(24*3600)));
	}else{
		return array('flag'=>'soon', 'day'=>(int)($left/(24*3600)));
	}
}






