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
		dump($sys_cfg);
		dump(D("Block")->getBlocks());
		dump(D("Area")->Areas());
		dump(D("Advs")->getAdvs());
		dump(D("Links")->getLinks());
		dump(D("Sort")->getSorts());
		dump(D("Property")->getProps());
		//
		$block1 = D("Block")->getGroupBlock("group1");
		$block2 = D("Block")->getGroupBlock("group2");
		$block3 = D("Block")->getGroupBlock("group3");
	}
	
}