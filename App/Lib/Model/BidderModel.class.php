<?php
/**
 * 投标模型
 * @author dapianzi
 *
 */
class BidderModel extends Model{
	/**
	 * 获取用户$mid的投标单
	 * @param string $mid 用户名
	 * @param boolen $all 是否包含未发布
	 */
	public function getBids($mid="", $row="", $all=FALSE){
		$join = "";
		$field = "";
		$order = "";
		$where = array("bid_mid"=>$mid);
		if(!$all){
			$where['bid_state'] = array("gt", 0);
		}
		$limit = empty($row)?"":$row;
		return $this->field()->join()->where($where)->order()->limit()->select();
	}
	
	/**
	 * 用户$mid 的投标数
	 * @param string $mid 用户名
	 * @param boolen $all 是否包含未发布
	 */
	public function getBidersCount($mid="", $all=FALSE){
		$where = array("bid_mid"=>$mid);
		if(!$all){
			$where['bid_state'] = array("gt", 0);
		}
		return $this->where($where)->count();
	}
	

	public function addAtts($id, $att){
		
		//$id = addslashes($id);
		//$old = $this->where("bid_id={$id}")->getField("pro_attachement", true);
		//$new = implode(",", array_merge(explode(",",$old), $att));
		//dump($new);exit;
		//return $this->where("pro_id={$id}")->setField("pro_attachement", $new);
	}
	
	public function delAtts($id, $att){
		//$id = addslashes($id);
		//$old = $this->where("pro_id={$id}")->getField("pro_attachement", true);
		//$new = implode(",",array_diff(explode(",", $old), $att));
		//dump($new);exit;
		//return $this->where("pro_id={$id}")->setField("pro_attachement", $new);
	}
	
	
}