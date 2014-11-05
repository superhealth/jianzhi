<?php
class AttachAction extends EmptyAction{
	/**
	 * 用户上传附件
	 * @param string $belong 附件所属的类型 
	 * 	pro_cover=> 项目封面
	 * 	project=>项目附件
	 * 	bid=>投标附件
	 * 	company=>公司用户认证
	 * 	person=>个人用户认证
	 * @param string $id
	 */
	public function upload($belong="", $id=""){
		$res_json = array("code"=>0,"data"=>"");
		$name = isset($_SESSION['member']) ? $_SESSION['member'] : $_SESSION['user'];
		if(empty($name)){
			$name = 'order'.date('Y-m-d', time());
		}
		if(empty($belong)||empty($id)){
			$res_json['data'] = "无效参数！";
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
					case 'pro_cover':
						D('Project')->updateCover($id, $att_data);
						break;
					case "project":
						D("Project")->addAtts($id, $att_data);
						break;
					case "bid":
						D("Bidder")->addAtts($id, $att_data);
						break;
					case "company":
						D("Membercompany")->addAtts($id, $att_data);
						break;
					case "person":
						D("Memberperson")->addAtts($id, $att_data);
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
	
	/**
	 * 删除附件
	 * @param string $belong 附件所属主体
	 * @param unknown $id
	 * @param unknown $attId
	 */
	public function del($belong, $id, $attId){
		
		//区分上传附件所属主体
		switch($belong){
			case "project":
				if(true==D("Attachement")->delAtt($attId)){
					D("Project")->delAtts($id, $attId);
					echo "success";exit;
				}
				break;
			case "bid":
				$att = D('Bidder')->where('bid_id='.$id)->getField($attId);
				if(true==D("Attachement")->delAtt($att)){
					D("Bidder")->delAtts($id, $attId);
					echo 'success';exit;
				}
				break;
			case "company":
				//D("Membercompany")->delAtts($id, $attId);
				break;
			case "person":
				//D("Memberperson")->delAtts($id, $attId);
				break;
		}
		echo '删除失败！';
		exit;	
	}
	
	/**
	 * 下载附件
	 * @param string $id
	 */
	public function download($id=""){
		$attach = M("attachement")->where("att_id={$id}")->find();
		if($attach){
			$download = attDownload($attach['att_path'], $attach['att_name']);
			if($download!==true){
				$this->closeWin = true;
				$this->error("下载失败：{$download}");
			}
		}else{
			$this->error("附件不存在！");
		}
	}
}