<?php
/**
 * 首页对应分类的推广项目
 * @author Carl 2014-10-30
 *
 */
class SortAdvAction extends BaseAction{
	/**
	 * 分类推广项目管理
	 */
	public function index(){
		$sortadv = M("sortadv");
		
		$sorts = D('Sorts')->getSorts();
		$sortadvs = $sortadv->select();
		$newSortAdvs = array();
		foreach ($sortadvs as $v){
			$newSortAdvs[$v['sa_sort']][] = $v;
		}		
		
		
		
		$this->assign('sorts', $sorts);
		$this->assign("lists", $newSortAdvs);
		$this->display();
		
	}
	
	/**
	 * 添加
	 */
	public function add(){
		$sort = $_GET['sort'];
		
		
		$this->display();
	}
	
	/**
	 * 保存
	 */
	public function save(){
		$sortadv = M('sortadv');
		// 添加
		if($_REQUEST['action'] == 'add'){
			$uploadInfo = upload_ex();
			if($uploadInfo[0]===false){
				$this->error('图片上传失败！'.$uploadInfo[1]);
			}else{
				$data = $sortadv->create();
				$data['sa_icon'] = $uploadInfo[1][0]['savename'];
				if($sortadv->add($data)){
					$proS
					$this->watchdog('新增', '添加')
				}
			}
		}else if($_REQUEST['action']=='edit'){
			$data = $sortadv->create();
			$upFlag = false;
			foreach ($_FILES as $f){
				if(!empty($f['name'])){
					$upFlag = true;break;
				}
			}
			if($upFlag){
				$uploadInfo = upload($_SESSION['user'], false);
				if($uploadInfo[0]){
					$data['sa_icon'] = $uploadInfo[1][0]['savename'];
				}else{
					$this->error("图片上传失败！".$uploadInfo[1]);
				}
			}
			if($sortadv->save($data)){
				$this->ajaxReturn(array('code'=>0, 'data'=>''));
			}else{
				$this->ajax
			}
		}else{
			$this->ajaxReturn(array('code'=>100, 'data'=>'错误的请求'));
		}
	}
	
	/**
	 * ajax 查询项目详情
	 */
	public function modify(){
		$sort 	= $_POST['sort'];
		$pro 	= $_POST['pro'];
		$proInfo = M('Project')->where("pro_sn='{$pro}'")->find();
		if(empty($proInfo)){
			$this->ajaxReturn(array('code'=>1, 'data'=> '不存在的项目！'));
		}else if($proInfo['pro_sort'] != $sort){
			$this->ajaxReturn(array('code'=>2, 'data'=> '项目的类别不符！'));
		}
		else{
			$proInfo['bids'] = D('Bidder')->getProBidersCount($proInfo['pro_id']);
			$this->ajaxReturn(array('code'=>0, 'data'=> $proInfo));
		}
		
	}
	
	/**
	 * 
	 */
	public function subArea($id=""){
		$info = M("area")->where("area_id={$id}")->find();
		if(!empty($info)){
			$areas = M("area")->where("area_reid={$id}")->select();
			$this->assign("areas", $areas);
			$this->assign("info",$info);
			$this->display();
		}else{
			$this->error("参数错误！");
		}
	}
	
	/** 
	 * 删除
	 */
	public function del($id=""){
		if(!per_check("area_edit")){
			$this->error("无此权限！");
		}
		$id = $this->getSubArea($id);
		if(empty($id)){
			$this->error("未选择删除的区域！");
		}else{
			$map = array("area_id"=> array("in", $id));
			if(M("area")->where($map)->delete()){
				$this->watchdog("删除","删除地区");
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}
		}		
	}
	
	/**
	 * 
	 */
	public function getSubArea($id){
		$subAreas = M("area")->where(array("area_reid"=>array("in", $id)))->getField("area_id", true);
		if(empty($subAreas)){
			return $id;
		}else{
			return array_merge($subAreas,$id, $this->getSubArea($subAreas));
		}	
	}

}

?>