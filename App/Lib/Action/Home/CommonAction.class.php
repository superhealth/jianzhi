<?php
/**
 * 公共模块
 * @author Carl
 *
 */
class CommonAction extends EmptyAction{
	/**
	 * 初始化方法
	 */
	public function _initialize(){
		//加载系统配置参数
		global $sys_cfg;
		if(empty($sys_cfg)){
			if(!file_exists(SYSCONF)){
				$sysconfig = M("sysconf")->select();
				$str = "<?php \nreturn array( \n";
				foreach($sysconfig as $v){
					switch($v['type']){
						case "string":
							$val = "\"{$v['value']}\"";
							break;
						case "int":
							$val = $v['value'];
							break;
						case "boolen":
							$val = $v['value'] == "Y" ? "true" : "false";
							break;
						default:
							$val = "\"{$v['value']}\"";
					}
					$str .= "\"{$v['key']}\" => {$val}, // {$v['desc']} \n";
				}
				$str .= "); \n?>";
				@chmod(SYSCONF_DIR, 0777);
				$f = fopen(SYSCONF, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！');</script>");
				fwrite($f,$str);
				fclose($f);
			}
			$sys_cfg = require(SYSCONF);
		}
		$this->memberInit();
	}
	/**
	 * 初始化会员信息
	 */
	function memberInit(){
		if(isset($_SESSION['member'])){
			$memberInfo = "";
			$this->assign("memberInfo", $memberInfo);
		}
	}
	
	
	public function getAuthcode(){
		import("ORG.Util.Image");
		Image::buildImageVerify($length=4, $mode=1, $type='png', $width=48, $height=22, $verifyName='authcode');
	}
}