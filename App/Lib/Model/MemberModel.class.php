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
	
	
}