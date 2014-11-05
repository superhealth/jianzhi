<?php
/**
 * 新闻动态
 * @author Carl
 *
 */
class NewsAction extends CommonAction{
	
	/**
	 * 新闻列表
	 * 
	 */
	public function index(){
		$news = M('News');
		// 分页
		$total = $news->count();
		import("Org.Util.Page");
		$page = new Page($total, 10);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$lists = $news->order('ne_adate')->limit($limit)->select();
		$this->assign('lists', $lists);
		$this->display();
	}
	
	/**
	 * 新闻详情
	 */
	public function view(){
		$id = $_GET['id'];
		$news = M('News')->where('ne_id='.$id)->find();
		if(empty($news)){
			$this->_empty();
		}
		$this->assign('news', $news);
		
		// 最新动态
		$latestNews = M('News')->field('ne_id, ne_title')->order('ne_adate DESC')->limit(10)->select();
		$this->assign('latestNews',$latestNews);
		$this->display();
	}
}