<?php
/**
 * 通知模型
 * @author dapianzi
 *
 */
class NoticeModel extends Model{
	//未读消息数
	public function noRead($mid){
		return $this->where("no_mid='{$mid}' AND no_read=0")->count();	
	}
	
	//发送消息
	public function sendNotice($mid, $subject, $content){
		$data = array(
			"no_mid"	=> $mid,
			"no_subject"	=> $subject,
			"no_content"	=> $content,
			"no_time"	=> time(),
			"no_read"	=> 0
		);
		return $this->add($data);
	}
	
	public function read($id){
		return $this->where(array("no_id"=> array("in", $id)))->setField("no_read", 1);
	}
}