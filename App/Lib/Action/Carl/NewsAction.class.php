<?php
class NewsAction extends BaseAction{
	
	public function index(){
		$news = M("News");
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$map['ne_title']  = array('like', "%{$words}%");
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $news->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "ne_order";
		$lists = $news->order($order)->limit($limit)->select();
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
	
	public function editNews(){
		$id = $_GET['id'];
		if(empty($id)){
			redirect(__URL__);
		}else{
			$info = M('News')->where('ne_id='.$id)->find();
			$this->assign($info);
			$this->display();
		}
	}
	public function saveNews(){
		$art = M('News');
		$data = $art->create();
		if(isset($data['ne_id'])){
			if($art->save($data)){
				$this->watchdog("修改", '修改《'.$data['ne_title'].'》栏目');
				$this->redirect(__URL__.'/editNews/id/'.$data['ne_id']);
			}else{
				$this->error('保存失败！');
			}
		}else{
			if($art->add($data)){
				$this->watchdog("新增", '新增加栏目《'.$data['pg_title'].'》');
				$this->redirect(__URL__);
			}else{
				$this->error('保存失败！');
			}
		}
	}
	
	public function addNews(){
		$this->display();
	}
	
	
	public function delNews(){
		$id = $_REQUEST['id'];
		$map = array(
			'ne_id'	=> array('in', $id)
		);
		$titles = M('News')->where($map)->getField('ne_title', true);
		if(M('News')->where($map)->delete()){
			$this->watchdog('删除', '删除栏目《'.implode('》《', $titles).'》');
			$this->redirect(__URL__);
		}else{
			$this->error('删除失败！');
		}
	}
	
	
	
}