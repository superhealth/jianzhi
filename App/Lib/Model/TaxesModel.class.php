<?php
/**
 * 税费模型
 * @author dapianzi
 *
 */
class TaxesModel extends Model{
	private $cacheFile = "/taxes.cache.php";	//缓存文件
	/**
	 * 获取所有税费选项
	 * @param string $flag 是否检查文件更新时间
	 */
	public function getTaxes($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? (time()-filectime($cacheFile)>864000) : $flag;
		if(!file_exists($cacheFile) || $flag){
			$this->updateCache();
		}
		return require($cacheFile);
	}
	
	/**
	 * 更新缓存文件
	 */
	public function updateCache(){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		@chmod(SYSCONF_DIR, 0777);
		$f = fopen($cacheFile, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！'); history.go(-1);</script>");
		$str = "<?php \nreturn array( \n";
		$taxes = $this->select();
		foreach($taxes as $v){
			$str .= "\"{$v['tax_id']}\"=>\"{$v['tax_name']}({$v['tax_value']}%)\",//{$v['tax_desc']}\n ";
		}
		$str .= "\n); \n?>";
		$rs = fwrite($f,$str);
		fclose($f);
		return $rs;
	}
	
}