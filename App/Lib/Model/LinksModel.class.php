<?php
/**
 * 友情链接模型
 * @author dapianzi
 *
 */
class LinksModel extends Model{
	private $cacheFile = "/links.cache.php";	//缓存文件
	/**
	 * 获取属性变量
	 * @param string $flag 是否检查文件更新时间
	 */
	public function getLinks($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? (time()-filectime($cacheFile)>864000) : $flag;
		if(!file_exists($cacheFile) || $flag){
			$this->updateCache();
		}
		return require($cacheFile);
	}
	
	/**
	 * 更新缓存
	 */
	public function updateCache(){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		$str = "<?php \nreturn array( \n";
		$links = $this->order("link_order")->select();
		foreach($links as $k=>$v){
			$str .= "'".$k."'=>array( \n";
			foreach($v as $key=>$val){
				$str .= "'".$key."'=>'".$val."', \n";
			}
			$str .= "\n),";
		}
		$str .= "\n); \n?>";
		@chmod(SYSCONF_DIR, 0777);
		$f = fopen($cacheFile, "w") or die('<script>alert("写入配置失败，请检查./cache目录是否可写入！"); history.go(-1);</script>');
		$rs = fwrite($f,$str);
		fclose($f);
		return $rs;
	}
}