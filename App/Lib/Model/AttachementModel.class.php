<?php
/**
 * 附件模型
 * @author Carl
 *
 */
class AttachementModel extends Model{
	//删除附件
	public function delAtt($id){
		if(!is_array($id)){
			$id = array($id);
		}
		$attInfo = $this->field("att_id, att_path")->where(array("att_id" => array("in",$id)))->select();
		$errors = array();
		foreach ($attInfo as $v){
			if(fileDelete($v['att_path'])){
				$this->where("att_id={$v['att_id']}")->delete();
			}else{
				$errors[] = $v['att_id'];
			}
		}
		if(count($errors)>0){
			return $errors;
		}else{
			return true;
		}
	}
	
	//添加附件
	public function addAtt($uploadInfo, $member=""){
		$data = array();
		foreach($uploadInfo as $v){
			$att_data = array(
					'att_name'	=> $v['savename'],
					'att_path'	=> trim($v['savepath'],".").$v['savename'],
					'att_type'	=> $v['extension'],
					'att_size'	=> getFileSize($v['size']),
					'att_mid'		=> $member,
					'att_time'	=> time()
			);
			//保存附件ID
			if($this->add($att_data)){
				$data[$v['key']] = $this->getLastInsID();
			}
		}
		return empty($data)?false:$data;
	}
	
	//获取附件
	public function getAtt($id){
		$map = array("att_id"=> array("in", $id));
		return $this->where($map)->select();
	}
	
}