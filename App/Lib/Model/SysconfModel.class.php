<?php
/**
 * 系统参数模型
 * @author dapianzi
 *
 */
class SysconfModel extends Model{
	private $cacheFile = SYSCONF;	//缓存文件
	/**
	 * 获取属性变量
	 * @param string $flag 是否检查文件更新时间
	 */
	public function sysConfs($flag=false){
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? (time()-filectime($this->cacheFile)>864000) : $flag;
		if(!file_exists($this->cacheFile) || $flag){
			$this->updateCache();
		}
		return require($this->cacheFile);
	}
	
	/**
	 * 
	 */
	public function getConf($key){
		$sysconfs = $this->sysConfs();
		return $sysconfs[$key];
	}
	
	/**
	 * 更新缓存
	 */
	public function updateCache(){
		@chmod(SYSCONF_DIR, 0777);
		$f = fopen(SYSCONF, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！'); history.go(-1);</script>");
		$sysconfig = $this->select();
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
		$rs = fwrite($f,$str);
		fclose($f);
		return $rs;
	}
}