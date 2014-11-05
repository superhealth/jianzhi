<?php
/**
 * 网站主题模块
 * @author dapianzi
 *
 */
class IndexAction extends CommonAction{
	
	public function _initialize(){
		parent::_initialize();
		$name = str_replace('/Index/', '', __ACTION__);
		$articleInfo = M('pages')->where('pg_name="'.$name.'"')->find();
		if(!empty($articleInfo)){
			$this->assign('article', $articleInfo);
			$this->display('Index:article');
			exit;
		}
		
	}
	
	public function index(){
		$this->assign('title', D('Sysconf')->getConf('cfg_title'));
		$this->assign('keywords', D('Sysconf')->getConf('cfg_keywords'));
		$this->assign('description', D('Sysconf')->getConf('cfg_description'));
		//$this->show("<h1>Welcome!</h1>");
		$sys_cfg = D("Sysconf")->sysConfs();
		$sorts = D("Sort")->getSorts();
		$this->assign('sorts', $sorts);
		
		$enums = D('Enumsort')->enums();
		$this->assign('enums', $enums);
		
		// 计算各个分类需要显示的项目数
		$sortAndAdvs = array();
		
		foreach($sorts as $key=>$sort){
			$num = 5-count($enums[$key]);
			$sortadvs = D('Sortadv')->getSortAdvs($key, $num);
			$firstLetter = strtoupper(substr(hanzi2zimu($sort),0,1));
			$sortAndAdvs[$firstLetter][] = array(
					'id'				=> $key,
					'name'		=> $sort,
					'enums'		=> $enums[$key],
					'sortadvs'	=> $sortadvs
			);
		}
		$this->assign('sortadvs',$sortAndAdvs);
		
		$props = D("Property")->getProps();
		$this->assign('props', $props);
		//
		$block1 = D("Block")->getGroupBlocks("轮播");
		$this->assign('sliders', $block1);
		$block2 = D("Block")->getGroupBlocks("名企");
		$this->assign('block2', $block2);
		$block3 = D("Block")->getGroupBlocks("group3");
		
		//新闻
		$news = M('News')->order('ne_adate DESC')->limit(3)->select();
		$this->assign('news', $news);
		
		
		// 最新项目列表
		$latestProject = M('project')->field('pro_subject, pro_id, pro_prop, pro_place')->where('pro_status=1')->order('pro_publishtime DESC')->limit(8)->select();
		foreach($latestProject as &$v){
			$v['pro_place'] = str_replace(array('|','中国','省','市'),array('','',' ',' '), $v['pro_place']);
			
		}
		$this->assign('latestPro', $latestProject);
		
		$this->assign('totalPro', M('project')->where(array("pro_status"=>array('gt', 0)))->count());
		$this->assign('totalBid', M('bidder')->where(array("bid_state"=>array('gt', 0)))->count());
		
		$this->assign('guides', M('guides')->order('gu_order')->select());
		
		$this->display();
	}
	
}