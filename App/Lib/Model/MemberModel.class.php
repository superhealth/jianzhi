<?php
/**
 * 用户模型
 * @author dapianzi
 *
 */
class MemberModel extends Model{
	//用户续费
	public function renewal($id, $year=0){
		$info = $this->where("mem_id='{$id}'")->find();
		if(empty($info)){
			$this->error = "无效的用户名！";
			return false;
		}
		$data['mem_id'] = $id;
		$expire = (int)$info['mem_expiretime'];
		if($info['mem_active']==1){
			$data['mem_expiretime'] = $expire>$_SERVER['REQUEST_TIME'] ? $expire + (31536000*$year) : $_SERVER['REQUEST_TIME'] + (31536000*$year);			
		}else{
			$data['mem_active'] = 1;
			$data['mem_expiretime'] = $_SERVER['REQUEST_TIME'] + (31536000*$year);
		}
		return $this->save($data);
	}
	
	/**
	 * 更新会员状态
	 * @param number $interval 检查周期
	 */
	public function updateMemberActive($interval=1800){
		// 上次更新时间
		$cornTime = M("cronhash")->where('ch_name="member"')->getField('ch_time');
		if($cornTime<$_SERVER['REQUEST_TIME']-$interval){
			// 更新过期会员状态
			M("member")->where("mem_active=1 AND mem_expiretime<=".$_SERVER['REQUEST_TIME'])->setField("mem_active", 0);
			// 保存更新时间
			M("cronhash")->where('ch_name="member"')->setField("ch_time", $_SERVER['REQUEST_TIME']);
		}
	}
	
	public function expired($member){
		$this->where("mem_id='{$member}'")->setField("mem_active", 0);
		// 发送消息提醒
		$subject = '年费到期通知';
		$content = $member.' 您好，您的会员已经到期。请马上续费以继续使用《订单网》的服务，点此<a href="/Due">立即续费</a>。';
		$type = '账户消息';
		D('Notice')->sendNotice($member, $subject, $content, $type);
	}
	
	
	/**
	 * 验证安全码
	 * @param string $user 用户名
	 * @param string $code 安全吗
	 */
	public function checkVerifyCode($user='', $code=''){
		$verify = M("member")->where("mem_id='{$user}'")->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = explode("-", $verify);
			if($verifyInfo[1] > time()-7*24*3600){
				if($code == $verifyInfo[0]){
					// 验证通过
					// 防止重复验证
					M("member")->where('mem_id="'.$user.'"')->save(array('mem_state'=>1, 'mem_verifycode'=>implode('-', $verifyInfo)));
					return true;
				}else{
					return '验证码错误！';
				}
			}else{
				return '验证码已过期！';
			}
		}else{
			return '用户信息错误！请确认用户名是否正确，返回重新验证。';
		}
	}
	
	/**
	 * 获取某一区域的用户
	 * @param array|string $areas 用户区域描述
	 * @return array 用户id
	 */
	public function getMemberInArea($areas){
		if(is_array($areas)){
			$areas = areaEncode($areas);
		}
		$memp = $this->join('zt_memberperson ON mem_id=mp_mid')->where('mp_addr like "%'.$areas.'%"')->getField('mem_id', true);
		$memc = $this->join('zt_membercompany ON mem_id=mc_mid')->where('mc_addr like "%'.$areas.'%"')->getField('mem_id', true);
		return array_merge($memp, $memc);
	}
	
	public function getMemberPlace($mid){
		$type = $this->where('mem_id="'.$mid.'"')->getField('mem_type');
		if($type==0){
			$place = M('memberperson')->where('mp_mid = "'.$mid.'"')->getField('mp_addr');
		}else{
			$place = M('membercompany')->where('mc_mid = "'.$mid.'"')->getField('mc_addr');
		}
		return $place;
	}
	
	/*public function getVerifyCode($user=''){
		$verify = M("member")->where("mem_id='{$user}'")->getField("mem_verifycode");
		if(!empty($verify)){
			$verifyInfo = explode("-", $verify);
			return $verifyInfo[0];
		}else{
			return false;
		}
	}*/
}