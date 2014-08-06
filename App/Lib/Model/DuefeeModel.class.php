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
	
	/**
	 * 创建续费单
	 * @param number $year 续费期限
	 * @param string $mid 用户id
	 * @return Ambigous <string, number>|boolean
	 */
	public function createDuefee($year = 1, $mid){
		$count = $this->where('due_mid="'.$mid.'" AND due_paystatus=0')->getField('due_id');
		if($count){
			return $count;
		}else{
			$data = array(
				'due_id' => createDuefeeSn(substr($mid, 0, 1)),
				'due_mid' => $mid,
				'due_discount' => $year,
				'due_price' => D('Sysconf')->getConf('cfg_duefee'),
				'due_paystatus'	=> 0,
				'due_createtime'	=> $_SERVER['REQUEST_TIME']
			);
			$rs = $this->add($data);
			if($rs){
				$subject = '【系统消息】 会员年费续费提醒';
				$duenotice = D('Sysconf')->getConf('cfg_duenotice');
				$content = '您的会员有效时间已不足'.$duenotice.'天，请及时续费以继续使用我们的服务，谢谢！';
				D("Notice")->sendNotice($mid, $subject, $content);
				return $this->getLastInsID();
			}else{
				return false;
			}
		}
	}
	
}