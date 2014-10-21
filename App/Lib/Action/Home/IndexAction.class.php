<?php
/**
 * 网站主题模块
 * @author dapianzi
 *
 */
class IndexAction extends CommonAction{
	public function index(){
		//$this->show("<h1>Welcome!</h1>");
		$sys_cfg = D("Sysconf")->sysConfs();
		$sorts = D("Sort")->getSorts();
		$enums = D('Emuns')->getEnums();
		$props = D("Property")->getProps();
		//
		$block1 = D("Block")->getGroupBlock("group1");
		$block2 = D("Block")->getGroupBlock("group2");
		$block3 = D("Block")->getGroupBlock("group3");
		
		// 最新项目列表
		$latestProject = M('project')->where('pro_status=1')->order('pro_publishtime DESC')->limit(8);
		
		
	}
	
}