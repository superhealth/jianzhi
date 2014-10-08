<?php
/**
 * 币值单位模型
* @author dapianzi
*
*/
class UnitModel extends Model{
	private $cacheFile = "/unit.cache.php";	//缓存文件
	/**
	 * 获取所有币值单位
	 * @param string $flag 是否检查文件更新时间
	 */
	public function getUnits($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? (time()-filemtime($cacheFile)>864000) : $flag;
		if(!file_exists($cacheFile) || $flag){
			$this->updateCache();
		}
		return require($cacheFile);
	}
	/**
	 * 获取币值名称
	 * @param int $id
	 * @return unknown
	 */
	public function getUnitName($id){
		$units = $this->getUnits();
		return $units[$id];
	}
	
	public function getUnitMultiple($id){
		return $this->where('unit_id='.$id)->getField('unit_multiple');
	}
	/**
	 * 获取币值名称为$name的币值
	 * @param string $name 币值名称
	 */
	public function getUnit($name=""){
		$units = $this->getUnits();
		foreach($units as $k=>$v){
			if($v==$name){
				return $k;
			}
		}
		return false;
	}
	
	/**
	 * 更新缓存
	 */
	public function updateCache(){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		$str = "<?php \nreturn array( \n";
		$units = $this->select();
		foreach($units as $v){
			$str .= "'".$v['unit_id']."'=>'".$v['unit_name']."', \n";
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