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
		$flag = $flag==false ? false : (time()-filectime($cacheFile)>864000);
		if(!file_exists($cacheFile) || $flag){
			$str = "<?php \nreturn array( \n";
			$sorts = $this->order("sort_order")->select();
			foreach($sorts as $v){
				$str .= "\"{$v['sort_id']}\"=>\"{$v['sort_name']}\",\n ";
			}
			$str .= "\n); \n?>";
			@chmod(SYSCONF_DIR, 0777);
			$f = fopen($cacheFile, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！');</script>");
			fwrite($f,$str);
			fclose($f);
		}
		return require($cacheFile);
	}

}



?>