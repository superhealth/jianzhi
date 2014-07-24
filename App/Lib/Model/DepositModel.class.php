<?php
/**
 * 保证金模型
 * @author dapianzi
 *
 */
class DepositModel extends Model{
	/**
	 * 获取用户$mid的保证金订单
	 * @param string $mid
	 */
	public function getMemDeposit($mid=""){
		$join = "zt_bidder ON de_id=bid_sn";
		$where = array("bid_mid"=> addslashes($mid));
		$field = "bid_id, bid_subject,bid_proid, bid_sn, zt_deposit.*";
		return $this->field($field)->join($join)->where($where)->select();
	}
	
	/**
	 * 获取项目$pid下的保证金订单
	 * @param unknown $pid
	 */
	public function getProDeposit($pid=""){
		$join = "zt_bidder ON de_id=bid_sn";
		$where = array("bid_proid"=> addslashes($pid));
		$field = "bid_id, bid_subject,bid_mid, bid_sn, zt_deposit.*";
		return $this->field($field)->join($join)->where($where)->select();
	}
	
	/**
	 * 退回保证金
	 * @param string $id 保证金订单id
	 */
	public function backDeposit($id=""){
		if(!is_array($id)){
			$id = array($id);
		}
		$unBack = $this->where("de_paystatus = 1")->select();
		foreach ($unBack as $v){
			//alipay::backDeposit($v);
		}
		return false;
	}
	
	/**
	 * 更新已开标的保证金状态
	 * @param number $interval 过期时间
	 * 
	 */
	public function updateDepositStatus($interval=1800){
		//检查项目状态是否更新
		//D('Project')->updatePorjectState();
		$cornTime = M("cronhash")->where('ch_name="deposit"')->getField('ch_time');
		if($cornTime<$_SERVER['REQUEST_TIME']-$interval){
			$de_id = $this->where('de_id in (SELECT bid_sn FROM zt_bidder WHERE bid_proid in (SELECT pro_id FROM zt_project WHERE pro_state>1))')->getField('de_id', true);
			$de_id_empty = $this->join('LEFT JOIN zt_bidder ON bid_sn=de_id LEFT JOIN zt_project ON pro_id=bid_proid')->where('pro_id=null')->getField('de_id', true);
			M("cornhash")->where('ch_name="deposit"')->setField('ch_time', $_SERVER['REQUEST_TIME']);
			dump($de_id_empty,$de_id);
		}
	}
	
}