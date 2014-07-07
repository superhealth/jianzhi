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
	
	/**
	 * 打包退款数据
	 * @param array $data
	 */
	public function packBackData($data="", $reason=""){
		if(empty($data)||!is_array($data)){
			return "";
		}
		$data = array();
		$reason = empty($reason) ? '管理员操作退回' : $reason;
		foreach($data as $v){
			$data[] = $v['due_id'].'^'.$v['due_price'].'^'.$reason;
		}
		return implode('#', $data);
	}
	
	public function createDuefee(){
		
	}
	
}