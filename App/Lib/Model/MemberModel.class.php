<?php
class MemberModel extends Model{
	private $yearstamp = 31536000;
	//用户续费
	public function renewal($id, $year=0){
		$info = $this->where("mem_id='{$id}'")->find();
		if(empty($info)){
			$this->error = "无效的用户名！";
			return false;
		}
		$data['mem_id'] = $id;
		$now = time();
		$expire = (int)$info['mem_expiretime'];
		if($info['mem_active']==1){
			$data['mem_expiretime'] = $expire>$now ? $expire + ($this->yearstamp*$year) : $now + ($this->yearstamp*$year);			
		}else{
			$data['mem_active'] = 1;
			$data['mem_expiretime'] = $now + ($this->yearstamp*$year);
		}
		return $this->save($data);
	}
	
	/**
	 * 更新会员状态
	 * @param number $interval 超时间隔
	 */
	public function updateMemberActive($interval=1800){
		$cornTime = M("cronhash")->where('ch_name="member"')->getField('ch_time');
		if($cornTime<$_SERVER['REQUEST_TIME']-$interval){
			//更新过期会员状态
			M("member")->where("mem_active=1 AND mem_expiretime<={$now}")->setField("mem_active", 0);
			//更新续费提醒
			M("cornhash")->where('ch_name="member"')->setField("ch_time", $_SERVER['REQUEST_TIME']);
		}
	}
	
	
}