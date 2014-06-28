<?php
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
	}
}