<?php
/**
 * 友情链接模型
* @author dapianzi
*
*/
class BlockModel extends Model{
	private $cacheFile = "/blocks.cache.php";	//缓存文件
	/**
	 * 获取属性变量
	 * @param string $flag 是否检查文件更新时间
	 */
	public function getBlocks($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? (time()-filectime($cacheFile)>864000) : $flag;
		if(!file_exists($cacheFile) || $flag){
			$this->updateCache();
		}
		return require($cacheFile);
	}

	/**
	 * 获取特定区域$area区域广告
	 */
	public function getGroupBlocks($group){
		$blocks = $this->getBlocks();
		return $blocks[$group];
	}
	
	/**
	 * 获得分组
	 */
	public function getGroups(){
		$blocks = $this->getBlocks();
		if(is_array($blocks)){
			return array_keys($blocks);
		}else{
			return "";
		}
	}
	
	/**
	 * 更新缓存
	 */
	public function updateCache(){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		$str = "<?php \nreturn array( \n";
		$blocks = $this->order("bl_order")->select();
		$newBlocks = array();
		foreach ($blocks as $v){
			$newBlocks[$v['bl_group']][] = $v;
		}
		foreach($newBlocks as $k=>$v){
			$str .= "'".$k."'=>array( \n";
			foreach($v as $key=>$val){
				$str .= "'".$key."'=>array( \n";
				foreach($val as $c=>$d){
					$str .= "'".$c."'=>'".$d."', \n";
				}
				$str .= "\n),";
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

?>