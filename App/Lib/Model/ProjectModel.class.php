<?php
/**
 * 项目模型
 * @author dapianzi
 *
 */
class ProjectModel extends Model{
	/**
	 * 获取项目已投标用户列表
	 * @param string $id 项目id
	 * @param boolen 
	 */
	public function getProjectMembers($id=""){
		$join = 'zt_bidder ON pro_id=bid_proid';
		$where = array("pro_id"=>$id);
		return $this->join($join)->where($where)->getField('bid_mid', true);
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
	
	/**
	 * 添加$id的项目的附件
	 * @param string $id
	 * @param array $att
	 * 
	 */
	public function addAtts($id, $att){
		$id = addslashes($id);
		$old = $this->where("pro_id={$id}")->getField("pro_attachement");
		$oldArr = empty($old) ? array() : explode(",",$old);
		$new = implode(",", array_merge($oldArr, $att));
		return $this->where("pro_id={$id}")->setField("pro_attachement", $new);
	}
	
	/**
	 * 更新$id的项目的封面
	 * @param string $id
	 * @param array $att
	 *
	 */
	public function updateCover($id, $att){
		$id = addslashes($id);
		if(is_array($att)){
			//字段名
			//$field = implode(",",array_keys($att));
			//$old = $this->field($field)->where("pro_id={$id}")->find();
			$where['pro_id'] = $id;
			return $this->where($where)->save($att);
		}else{
			$this->error = "尝试修改的附件字段为空！";
			return false;
		}
	}
	
	/**
	 * 删除$id的项目的附件
	 * @param string $id
	 * @param array $att
	 */
	public function delAtts($id, $att){
		$id = addslashes($id);
		if(!is_array($att)){
			$att = array($att);
		}
		$old = $this->where("pro_id={$id}")->getField("pro_attachement");
		$new = implode(",",array_diff(explode(",", $old), $att));
		return $this->where("pro_id={$id}")->setField("pro_attachement", $new);
	}
	
	/**
	 * 检查是否开标，更新项目状态
	 * @param number $interval 检查周期
	 */
	public function updateProState($interval=1800){
		$cornTime = M("cornhash")->where('ch_name="project"')->getField('ch_time');
		if($cornTime<$_SERVER['REQUEST_TIME']-$interval){
			$where = array('pro_opentime'=>array('lt', $_SERVER['REQUEST_TIME']));
			//$de_id = $this->where($where)->setField('pro_state', 2);
			$pro = $this->where($where)->select();
			//dump($pro);
		}
	}
	
	/**
	 * 
	 */
	public function browser($id){
		return $this->where('pro_id='.$id)->setInc('pro_view');
	}
}