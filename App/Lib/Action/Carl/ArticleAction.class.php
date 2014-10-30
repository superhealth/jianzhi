<?php
/**
 * 栏目管理
 * @author Carl
 * @date 2014-10-26
 */
class ArticleAction extends BaseAction{
	/**
	 * 列表
	 */
	public function index(){
		$article = M("Pages");
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['pg_name']  = array('like', "%{$words}%");
				$where['pg_title']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $article->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "pg_order";
		$lists = $article->order($order)->limit($limit)->select();
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
	public function editArticle(){
		$id = $_GET['id'];
		if(empty($id)){
			redirect(__URL__);
		}else{
			$info = M('Pages')->where('pg_id='.$id)->find();
			$this->assign('info', $info);
			$this->display();
		}
	}
	/**
	 * 保存
	 */
	public function saveArticle(){
		$art = M('Pages');
		$data = $art->create();
		if(isset($data['pg_id'])){
			// 保存编辑
			if($art->save($data)){
				$this->watchdog("修改", '修改《'.$data['pg_title'].'》栏目');
				$this->redirect(__URL__.'/editArticle/id/'.$data['pg_id']);
			}else{
				$this->error('保存失败！');
			}
		}else{
			// 保存新增
			if($art->add($data)){
				$this->watchdog("新增", '新增加栏目《'.$data['pg_title'].'》');
				$this->redirect(__URL__);
			}else{
				$this->error('保存失败！');
			}
		}
	}
	/**
	 * 添加
	 */
	public function addArticle(){
		$this->display();
	}
	/**
	 * 删除
	 */
	public function delArticle(){
		$id = $_REQUEST['id'];
		$map = array(
			'pg_id'	=> array('in', $id)
		);
		$names = M('Pages')->where($map)->getField('pg_title', true);
		if(M('Pages')->where($map)->delete()){
			$this->watchdog('删除', '删除栏目《'.implode('》《', $names).'》');
			$this->redirect(__URL__);
		}else{
			$this->error('删除失败！');
		}
	}
	
	/**
	 * 查找是否已经存在链接名
	 */  
	public function pgNameExist(){
		$name = $_REQUEST['name'];
		$count = M('Pages')->where('pg_name="'.$name.'"')->count();
		if($count>0){
			echo 'exist';
		}else{
			echo 'ok';
		}
	}
	
	
}