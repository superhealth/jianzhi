<?php
/**
 * 项目收藏模型
 * @author dapianzi
 *
 */
class CollectionModel extends Model{
	/**
	 * 
	 * @param string $mid
	 * @return Ambigous <mixed, string, boolean, NULL, unknown, multitype:, void, multitype:multitype: >
	 */
	public function getCollections($mid=""){
		$mid = addslashes($mid);
		return $this->field("zt_collection.*, pro_subject")->join("zt_project ON co_proid=pro_id")->where("co_mid='{$mid}'")->select();
	}
}