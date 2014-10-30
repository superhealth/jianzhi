<?php
/**
 * 新闻动态管理
 * @author Carl
 * @date 2014-10-27
 */
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
		$order = "ne_adate DESC";
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
			$this->assign('info', $info);
			$this->display();
		}
	}
	public function saveNews(){
		$art = M('News');
		$data = $art->create();
		$data['ne_adate'] = $_SERVER['REQUEST_TIME'];
		if(isset($data['ne_id'])){
			if($art->save($data)){
				$this->watchdog("修改", '修改新闻公告《'.$data['ne_title'].'》');
				$this->redirect(__URL__.'/editNews/id/'.$data['ne_id']);
			}else{
				$this->error('保存失败！');
			}
		}else{
			if($art->add($data)){
				$this->watchdog("新增", '新增加新闻公告《'.$data['ne_title'].'》');
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
			$this->watchdog('删除', '删除新闻《'.implode('》《', $titles).'》');
			$this->redirect(__URL__);
		}else{
			$this->error('删除失败！');
		}
	}
	
	
	
}