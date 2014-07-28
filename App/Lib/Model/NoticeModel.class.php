<?php
/**
 * 通知模型
 * @author dapianzi
 *
 */
class NoticeModel extends Model{
	/**
	 * 用户$mid的
	 * @param string $mid
	 * @return Ambigous <mixed, boolean, NULL, string, unknown, multitype:, multitype:multitype: , void>
	 */
	public function notices($mid, $type){
		if(!empty($type)){
			$where['no_type'] = $type;
		}
		$where['no_mid'] = $mid;
		return $this->where($where)->select();
	}
	
	/**
	 * 用户$mid的未读通知数
	 * @param string $mid
	 */
	public function noRead($mid){
		return $this->where("no_mid='{$mid}' AND no_read=0")->count();	
	}
	
	/**
	 * 发送短消息
	 * @param string $mid
	 * @param string $subject
	 * @param string $content
	 * @return Ambigous <mixed, boolean, string, false, number>
	 */
	public function sendNotice($mid, $subject, $content, $type){
		$data = array(
			"no_mid"	=> $mid,
			"no_subject"	=> $subject,
			"no_content"	=> $content,
			"no_time"	=> time(),
			"no_read"	=> 0,
			'no_type'	=> $type
		);
		return $this->add($data);
	}
	
	public function read($id){
		return $this->where(array("no_id"=> array("in", $id)))->setField("no_read", 1);
	}
}