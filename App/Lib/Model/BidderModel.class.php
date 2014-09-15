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
	public function getMemBids($mid="", $all=true, $row=""){
		$join = array(
				"zt_project ON bid_proid=pro_id",
				"zt_deposit ON bid_sn=de_id"
		);
		$field = "zt_bidder.*,LEFT(bid_subject,20) subject, pro_subject, de_deposit, de_paystatus";
		$order = "bid_createtime DESC";
		$where = array("bid_mid"=>addslashes($mid));
		if(!$all){
			$where['bid_state'] = array("gt", 0);
		}
		$limit = empty($row)?"":$row;
		return $this->field($field)->join($join)->where($where)->order($order)->limit($limit)->select();
	}
	
	/**
	 * 获取项目$pid的投标单
	 * @param string $pid 用户名
	 * @param boolen $all 是否包含未发布
	 */
	public function getProBids($pid="", $all=true, $row=""){
		$join = array(
				"zt_project ON bid_proid=pro_id",
				"zt_deposit ON bid_sn=de_id"
		);
		$field = "zt_bidder.*,LEFT(bid_subject,20) subject, pro_subject, de_deposit, de_paystatus";
		$order = "bid_publishtime DESC";
		$where = array("bid_proid"=>addslashes($pid));
		if(!$all){
			$where['bid_state'] = array("gt", 0);
		}
		$limit = empty($row)?"":$row;
		return $this->field($field)->join($join)->where($where)->order($order)->limit($limit)->select();
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

	/**
	 * 用户$mid 的投标数
	 * @param string $mid 用户名
	 * @param boolen $all 是否包含未发布
	 */
	public function getProBidersCount($pid="", $all=FALSE){
		$where = array("bid_proid"=>$pid);
		return $this->where($where)->count();
	}
	
	/**
	 * 更新投标单附件
	 * @param int $id 更新的投标单id
	 * @param array $att 字段对应附件id的索引数组
	 * @return Ambigous <boolean, false, number>|boolean
	 */
	public function updateAtts($id, $att){
		$id = addslashes($id);
		if(is_array($att)){
			//字段名
			//$field = implode(",",array_keys($att));
			//$old = $this->field($field)->where("bid_id={$id}")->find();
			$data['bid_id'] = $id;
			foreach($att as $k=>$v){
				$data[$k]	= $v;
			}
			return $this->save($data);
		}else{
			$this->error = "尝试修改的附件字段为空！";
			return false;
		}
	}
	
	public function delAtts($id, $att){
		
	}
	
	public function addAtts($id, $att){
		
	}
}