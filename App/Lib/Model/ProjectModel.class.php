<?php
/**
 * 项目模型
 * @author dapianzi
 *
 */
class ProjectModel extends Model{
	/**
	 * 获取用户$mid的招标单
	 * @param string $mid 用户名
	 * @param boolen $all 是否包含未发布
	 */
	public function getProjects($mid="", $row="", $all=FALSE){
		$join = "";
		$field = "";
		$order = "";
		$where = array("pro_mid"=>$mid);
		if(!$all){
			$where['pro_state'] = array("gt", 0);
		}
		$limit = empty($row) ? "" : $row;
		return $this->field()->join()->where($where)->order()->limit()->select();
	}
	
	/**
	 * 用户$mid 的招标数
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
	
	//删除项目中的附件
	public function addAtts($id, $att){
		$id = addslashes($id);
		$old = $this->where("pro_id={$id}")->getField("pro_attachement");
		$oldArr = empty($old) ? array() : explode(",",$old);
		$new = implode(",", array_merge($oldArr, $att));
		return $this->where("pro_id={$id}")->setField("pro_attachement", $new);
	}
	
	public function delAtts($id, $att){
		$id = addslashes($id);
		if(!is_array($att)){
			$att = array($att);
		}
		$old = $this->where("pro_id={$id}")->getField("pro_attachement");
		$new = implode(",",array_diff(explode(",", $old), $att));
		return $this->where("pro_id={$id}")->setField("pro_attachement", $new);
	}	
}