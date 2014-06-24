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
}