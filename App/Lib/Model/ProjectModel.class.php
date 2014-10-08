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
	public function getProjectMembers($id=0){
		$join = 'zt_bidder ON pro_id=bid_proid';
		$where = array("pro_id"=>$id);
		return $this->join($join)->where($where)->getField('bid_mid', true);
	}
	
	/**
	 * 查询用户$mid的招标项目id
	 * @param string $mid
	 * @return Ambigous <mixed, NULL, multitype:Ambigous <unknown, string> unknown , unknown, multitype:Ambigous <unknown, string> Ambigous <multitype:> >
	 */
	public function getProjectIdOfMember($mid=""){
		return $this->where("pro_mid=$mid")->getField('pro_id', true);
	}
	
	/**
	 * 查询用户$mid的招标项目信息
	 * @param string $mid
	 * @return Ambigous <mixed, boolean, NULL, string, unknown, multitype:, multitype:multitype: , void>
	 */
	public function getProjectsInfoOfMember($mid=""){
		return $this->where("pro_mid=$mid")->select();
	}
	
	/**
	 * 用户$mid 的招标数
	 * @param string $mid 用户名
	 * @param boolen $all 是否包含未发布
	 */
	public function getBidersCount($mid=0, $all=FALSE){
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
	 * 浏览
	 */
	public function browser($id){
		return $this->where('pro_id='.$id)->setInc('pro_view');
	}
	
	/**
	 * 更新项目开标状态
	 * @param number $interval 检查周期
	 */
	public function updatePorjectStatus($interval=180){
		// 上次更新时间
		$cornTime = M("cronhash")->where('ch_name="project"')->getField('ch_time');
		if($cornTime<$_SERVER['REQUEST_TIME']-$interval){
			$where = array(
					'pro_status'	=> 1,
					'pro_opentime'	=> array('lt', $_SERVER['REQUEST_TIME'])
			);
			//项目id
			$proids = $this->where($where)->getField('pro_id', true);
			if(is_array($proids) && count($proids)>0){
				// 更新开标状态
				$this->where($where)->setField("pro_status", 2);
				// 发送开标通知
				$bidders = M('bidder')->field('pro_id,pro_subject, bid_mid, bid_id')->join('zt_project ON pro_id=bid_proid')->where(array('bid_proid'=> array('in', $proids)))->select();
				foreach($bidders as $bid){
					$mid = $bid['bid_mid'];
					$subject = '项目开标通知';
					$content = "{$mid}您好！您所投标的项目《{$bid['pro_subject']}》已经开标啦。";
					$content .= "<br /><a href='".__GROUP__."/Project/detail/id/{$bid['pro_id']}'>查看项目详情</a>";
					$content .= "<br /><a href='".__GROUP__."/Bid/myBid/id/{$bid['bid_id']}'>查看我的投标</a>";
					D('Notice')->sendProNotice($mid, $subject, $content);
				}
			}
			// 保存更新时间
			M("cronhash")->where('ch_name="project"')->setField("ch_time", $_SERVER['REQUEST_TIME']);
		}
	}
	
	
}