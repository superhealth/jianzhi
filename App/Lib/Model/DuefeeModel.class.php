<?php
/**
 * 续费单模型
 * @author dapianzi
 *
 */
class DuefeeModel extends Model{
	/**
	 * 获取用户$mid的年费续费单
	 * @param string $mid 用户名
	 * @param string $status 支付状态
	 * 
	 */
	public function getDuefees($mid="", $status="all"){
		$where = array(
			"du_mid"	=> $mid
		);
		if($status!="all"){
			$where['du_paystatus'] = $status;
		}
		return $this->where($where)->select();
	}
	
	/**
	 * 获取用户$mid 的续费单数量
	 * @param string $mid 用户名
	 * @param string $status 支付状态
	 */
	public function getDuefeeCount($mid="", $status = "0"){
		$where = array(
				"du_mid"	=> $mid
		);
		if($status!="all"){
			$where['du_paystatus'] = $status;
		}
		return $this->where($where)->count();
	}
}