<?php
class EnumsortModel extends Model{
	private $cacheFile = "/enum.cache.php";	//缓存文件
	/**
	 * 获取详细分类变量
	 * @param string $flag 是否检查文件更新时间
	 */
	public function enums($flag=false){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		// 检查缓存文件是否存在，或者超过10天更新文件，10*24*3600 = 864000
		$flag = $flag==false ? false : (time()-filectime($cacheFile)>864000);
		if(!file_exists($cacheFile) || $flag){
			$this->updateCache();
		}
		return require($cacheFile);
	}
	
	/**
	 * 获取某一主类下面的详细分类
	 * @param int $sortid 主类id
	 * @param string $base 详细分类分组名
	 * @return array 详细分类的数组
	 */
	public function getEnums($sortid, $base=""){
		$enums = $this->enums();
		if(empty($base)){
			return $enums[$sortid];
		}
		return $enums[$sortid][$base];
	}
	
	/**
	 * 
	 */
	public function updateCache(){
		$cacheFile = SYSCONF_DIR.$this->cacheFile;
		$str = "<?php \nreturn array( \n";
		//主类
		$sortid = $this->field("es_sort_id")->group("es_sort_id")->getField("es_sort_id", true);
		foreach($sortid as $s){
			$str .= "\"{$s}\" => array(";
			$bases = $this->field("es_base")->where("es_sort_id={$s}")->group("es_base")->getField("es_base", true);
			foreach($bases as $b){
				$str .= "\"{$b}\" => array(";
				$enums = $this->where("es_base='{$b}'")->order("es_order")->getField("es_name", true);
				foreach($enums as $e){
					$str .= "\"{$e}\",";
				}
				$str .= "\n),";
			}
			$str .="\n),";
		}
		$str .= "\n); ?>";
		@chmod(SYSCONF_DIR, 0777);
		$f = fopen($cacheFile, "w") or die("<script>alert('写入配置失败，请检查./cache目录是否可写入！'); history.go(-1);</script>");
		fwrite($f,$str);
		fclose($f);
	}
	
}