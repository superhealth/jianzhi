<?php 
/**
 * 分类模型
 * @author dapianzi
 *
 */
class SortModel extends Model{
	private $cacheFile = "/sort.cache.php";	//缓存文件
	/**
	 * 获取分类变量
	 * @param string $flag 是否检查文件更新时间
	 */
	public function getSorts($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? (time()-filemtime($cacheFile)>864000) : $flag;
		if(!file_exists($cacheFile) || $flag){
			$this->updateCache();
		}
		return require($cacheFile);
	}
	
	public function getOneSort($id=''){
		$sorts = $this->getSorts();
		if($id===''){
			return '';
		}else{
			return $sorts[$id];
		}
	}
	
	/**
	 * 更新缓存文件
	 */
	public function updateCache(){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		@chmod(SYSCONF_DIR, 0777);
		$f = fopen($cacheFile, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！'); history.go(-1);</script>");
		$str = "<?php \nreturn array( \n";
		$sorts = $this->order("sort_order")->select();
		foreach($sorts as $v){
			$str .= "\"{$v['sort_id']}\"=>\"{$v['sort_name']}\",\n ";
		}
		$str .= "\n); \n?>";
		$rs = fwrite($f,$str);
		fclose($f);
		return $rs;
	}

}



?>