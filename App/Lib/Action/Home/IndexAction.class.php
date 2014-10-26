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
		$enums = D('Enumsort')->enums();
		$props = D("Property")->getProps();
		//
		$block1 = D("Block")->getGroupBlocks("group1");
		$block2 = D("Block")->getGroupBlocks("group2");
		$block3 = D("Block")->getGroupBlocks("group3");
		
		// 最新项目列表
		$latestProject = M('project')->where('pro_status=1')->order('pro_publishtime DESC')->limit(8);
		
		$this->display();
	}
	
}