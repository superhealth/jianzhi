<?php
/**
 * 帮助支持模块
 * @author dapianzi
 *
 */
class SupportAction extends CommonAction{
	/**
	 * 服务中心
	 */
	public function index(){
		$this->display();
	}
	
	/**
	 * 联系客服
	 */
	public function contact(){
		$this->display();
	}
	
	/**
	 * 常见问答
	 */
	public function faq(){
		$this->display();
	}
	
	/**
	 * 关于我们
	 */
	public function about(){
		$this->display();
	}
	
}