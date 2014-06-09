<?php
/**
 * 网站主题模块
 * @author Carl
 *
 */
class IndexAction extends CommonAction{
	public function index(){
		$this->show("<h1>Welcome!</h1>");
		global $sys_cfg;
		dump($sys_cfg);
	}
	
}