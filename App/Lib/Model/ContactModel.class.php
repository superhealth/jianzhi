<?php
/**
 * 联系人模型
 * @author dapianzi
 *
 */
class ContactModel extends Model{
	
	/**
	 * 保存联系人
	 * @param array $data 联系人信息数组
	 * @return 
	 */
	public function saveContact($data=""){
		if(empty($data)){
			$data = $this->create();
		}
		if(!empty($data['con_id'])){
			if($this->save($data)){
				return $data['con_id'];
			}else{
				return false;
			}
		}else{
			if($this->add($data)){
				return $this->getLastInsID();
			}else{
				return false;
			}
		}
	}
}