<?php
/**
 * 项目收藏模型
 * @author dapianzi
 *
 */
class CollectionModel extends Model{
	/**
	 * 用户$mid的收藏列表
	 * @param string $mid
	 * @return Ambigous <mixed, string, boolean, NULL, unknown, multitype:, void, multitype:multitype: >
	 */
	public function getCollections($mid=""){
		$mid = addslashes($mid);
		return $this->field("zt_collection.*, pro_subject")->join("zt_project ON co_proid=pro_id")->where("co_mid='{$mid}'")->select();
	}
	
	/**
	 * 添加收藏
	 * @param string $pid 项目id
	 * @param string $mid 用户id
	 * @return Ambigous <mixed, boolean, string, false, number>
	 */
	public function addCollection($pid, $mid){
		$data = array(
			"co_proid"	=> $pid,
			"co_mid"	=> $mid
		);
		if($this->where($data)->count()){
			$this->error = '已收藏的项目！';
			return false;
		}else{
			$data['co_time'] = time();
			return $this->add($data);
		}
		
	}
	
	/**
	 * 
	 * @param string $coid
	 */
	public function cancelCollection($coid, $mid){
		return $this->where("co_id='{$coid}' AND co_mid='{$mid}'")->delete();
	}
	
	public function isCollected($pid, $mid){
		$where = array(
				"co_proid"	=> $pid,
				"co_mid"	=> $mid
		);
		return $this->where($where)->getField('co_id');
	}
	
}