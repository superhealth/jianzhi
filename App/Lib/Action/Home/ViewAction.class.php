<?php
class ViewAction extends CommonAction{
	public function index(){
		redirect(__APP__);
	}
	
	public function member($id=""){
		$id = addslashes($id);
		$info = M("member")->where("mem_id='{$id}'")->find();
		$this->assign($info);
		$this->display();
	}
	
	public function project($id=""){
		$id = addslashes($id);
		$info = M("project")->where('pro_id="'.$id.'"')->find();
		if(empty($info)){
			echo "出错了";
			//send_http_status(404);
		}
		//项目状态
		$this->assign("status", array(0=> "未发布", 1=> "招标中", 2=> "已开标", 3=>"关闭"));
		//投标限制
		$this->assign("limits", array(0=> "不限", 1=> "个人", 2=> "企业"));
		
		$atts = D("Attachement")->getAtt($info['pro_attachement']);
		$this->assign("atts", $atts);
		// 应标单
		$bidders = D("Bidder")->getProBids($info['pro_id']);
		$this->assign("bidders", $bidders);
		$this->assign("info", $info);
		dump($info);
		dump($atts);
		dump($bidders);
		$this->display();
	}
	
	public function bid($id=""){
		$id = addslashes($id);
		$info = M("bidder")->where("bid_id='{$id}'")->find();
		$this->assign($info);
		$this->display();
	}
	
}