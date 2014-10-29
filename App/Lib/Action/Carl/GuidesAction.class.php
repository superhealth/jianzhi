<?php
/**
 * 使用指南
 * @author Carl
 * @date 2014-10-26
 */
class GuidesAction extends BaseAction{
	/**
	 * 列表
	 */
	public function index(){
		$guides = M("Guides");
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['gu_name']  = array('like', "%{$words}%");
				$where['gu_title']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $guides->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "gu_order";
		$lists = $guides->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($lists as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/ig", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("lists", $lists);
		$this->display();
	}
	/**
	 * 编辑
	 */
	public function editGuides(){
		$id = $_GET['id'];
		if(empty($id)){
			redirect(__URL__);
		}else{
			$info = M('Guides')->where('gu_id='.$id)->find();
			$this->assign('info', $info);
			$this->display();
		}
	}
	/**
	 * 保存
	 */
	public function saveGuides(){
		$art = M('Guides');
		$data = $art->create();
		if(isset($data['gu_id'])){
			// 保存修改
			if($art->save($data)){
				$this->watchdog("修改", '修改《'.$data['gu_title'].'》栏目');
				$this->redirect(__URL__.'/editArticle/id/'.$data['gu_id']);
			}else{
				$this->error('保存失败！');
			}
		}else{
			// 保存新增
			if($art->add($data)){
				$this->watchdog("新增", '新增加栏目《'.$data['gu_title'].'》');
				$this->redirect(__URL__);
			}else{
				$this->error('保存失败！');
			}
		}
	}
	/**
	 * 添加
	 */
	public function addGuides(){
		$this->display();
	}
	/**
	 * 删除
	 */	
	public function delGuides(){
		$id = $_REQUEST['id'];
		$map = array(
			'gu_id'	=> array('in', $id)
		);
		$names = M('Guides')->where($map)->getField('gu_title', true);
		if(M('Guides')->where($map)->delete()){
			$this->watchdog('删除', '删除栏目《'.implode('》《', $names).'》');
			$this->redirect(__URL__);
		}else{
			$this->error('删除失败！');
		}
	}
	
	
	
}