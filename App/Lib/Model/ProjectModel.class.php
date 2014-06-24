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
}