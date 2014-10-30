<?php
/**
 * 首页对应分类的推广项目
 * @author Carl 2014-10-30
 *
 */
class SortAdvAction extends BaseAction{
	/**
	 * 
	 */
	public function index(){
		$sortadv = M("sortadv");
		$field = "sa_id, sa_name, sa_pic, sa_prosn, sa_sortid";
		$join = "a LEFT JOIN zt_area b ON a.area_id=b.area_reid";
		$areas = $sortadv->field($field)->join($join)->where("a.area_reid=0")->order("forder, sorder")->select();
		foreach($areas as &$v){
			$v['subcount'] = M("area")->where("area_reid={$v['sid']}")->count();
			$areasNew[$v['fid']]['subs'][] = $v;
			if(!isset($areasNew[$v['fid']]['order'])){
				$areasNew[$v['fid']]['order'] = $v['forder'];
			}
			if(!isset($areasNew[$v['fid']]['name'])){
				$areasNew[$v['fid']]['name'] = $v['fname'];
			}
			if(!isset($areasNew[$v['fid']]['count'])){
				$areasNew[$v['fid']]['count'] = 0;
			}
			$areasNew[$v['fid']]['count']++;
		}
		$this->assign("areas", $areasNew);
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
		$data = $sortadv->create();
		
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