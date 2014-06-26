<?php
class AttachAction extends EmptyAction{
	public function upload($belong="", $id=""){
		$res_json = array("code"=>0,"data"=>"");
		$name = isset($_SESSION['member']) ? $_SESSION['member'] : $_SESSION['user'];
		if(empty($name)){
			$res_json['data'] = "无效用户！";
			echo json_encode_nonull($res_json);
			exit;
		}
		//上传
		$uploadInfo = upload($name,false);
		if($uploadInfo[0]){
			//添加到附件表
			$att_data = D("Attachement")->addAtt($uploadInfo[1], $name);
			if(!empty($att_data)){
				//区分上传附件所属主体
				switch($belong){
					case "project":
						D("Project")->addAtts($id, $att_data);
						break;
					case "bid":
						D("Bidder")->addAtts($id, $att_data);
						break;
				}
				$res_json['data'] = D("Attachement")->getAtt($att_data);
				$res_json['code'] = 1;
			}else{
				$res_json['data'] = "附件保存失败!";
			}
		}else{
			$res_json['data'] = $uploadInfo[1];
		}
		echo json_encode_nonull($res_json);
		exit;
	}
	
	public function del($belong, $id, $attId){
		if(true!==D("Attachement")->delAtt($attId)){
			echo "删除失败！";
		}else{
			//区分上传附件所属主体
			switch($belong){
				case "project":
					D("Project")->delAtts($id, $att_data);
					break;
				case "bid":
					D("Bidder")->delAtts($id, $att_data);
					break;
			}
			echo "success";
		}
		exit;	
	}
}