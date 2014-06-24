<?php
class AreaModel extends Model{
	private $cacheFile = "/area.cache.php";	//缓存文件
	/**
	 * 获取地区变量
	 * @param string $flag 是否检查文件更新时间
	 */
	public function Areas($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? false : (time()-filectime($cacheFile)>864000);
		if(!file_exists($cacheFile) || $flag){
			$str = "<?php \nreturn array( \n";
			$areas = M("area")->where("area_reid=0")->select();
			$str .= $this->getAreas($areas);
			$str .= "\n); \n?>";
			@chmod(SYSCONF_DIR, 0777);
			$f = fopen($cacheFile, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！');</script>");
			fwrite($f,$str);
			fclose($f);
		}
		return require($cacheFile);
	}
	
	/**
	 * 遍历子地区
	 * @param array $areas 上级地区
	 * @return string
	 */
	private function getAreas($areas){
		$str = "";
		foreach($areas as $v){
			$str .= "\"{$v['area_id']}\" => array( \n";
			$str .= "\"name\" => \"{$v['area_name']}\",\n";
			$subAreas = $this->where("area_reid={$v['area_id']}")->select();
			if(is_array($subAreas)){
				$str .= "\"subArea\" => array( \n";
				$str .= $this->getAreas($subAreas);
				$str .= "\n ),\n";
			}
			$str .= "\n),";
		}
		return $str;
	}
	
	public function getSubAreas($id=0){
		
	}
}

?>