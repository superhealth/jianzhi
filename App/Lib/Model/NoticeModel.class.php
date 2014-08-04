<?php
/**
 * 通知模型
 * @author dapianzi
 *
 */
class NoticeModel extends Model{
	/**
	 * 用户$mid的
	 * @param string $mid 用户id
	 * @param string $type 消息类型
	 * @param number $row 消息数
	 * @return Ambigous <mixed, boolean, NULL, string, unknown, multitype:, multitype:multitype: , void>
	 */
	public function notices($mid, $type="", $row = 10){
		$param = array();
		if(!empty($type)){
			$where['no_type'] = $type;
			$param['type'] = $type;
		}
		if($_REQUEST['flag']=='no'){
			$where['no_read'] = '0';
			$param['flag'] = $_REQUEST['flag'];
		}
		$where['no_mid'] = $mid;
		import("Org.Util.Page");
		//total notices;
		$result['total'] = $this->where($where)->count();
		// noread:
		$map = $where;
		$map['no_read'] = 0;
		$result['noread'] = $this->where($map)->count();
		unset($map);
		$page = new Page($result['total'], $row, $param);
		$limit = $page->firstRow.",".$page->listRows;
		$result['pager'] = $page->shown();
		$result['data'] =  $this->where($where)->order('no_time DESC')->limit($limit)->select();
		return $result;
	}
	
	/**
	 * 查找$mid 的$type 类型消息数
	 * @param unknown $mid
	 * @param unknown $type
	 * @param boolen $flag 是否未读数，默认为true
	 */
	public function noticeCount($mid, $type = "", $flag = true){
		if($flag===true){
			$where['no_read'] = 0;
		}
		$where['no_mid'] = $mid;
		if(!empty($type)){
			$where['no_type'] = $type;
			return $this->where($where)->count();
		}else{
			return $this->where($where)->group('no_type')->getField('no_type, count(*) num');
		}
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
	
	/**
	 * 设置id为$id 的消息为已读
	 * @param int $id
	 * @return Ambigous <boolean, false, number>
	 */
	public function read($id){
		return $this->where(array("no_id"=> array("in", $id)))->setField("no_read", 1);
	}
}