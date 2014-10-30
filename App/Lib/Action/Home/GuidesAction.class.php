<?php
/**
 * 新手指南
 * @author Carl
 * @date 2014-10-28
 */
class GuidesAction extends CommonAction{
	
	public function _initialize(){
		parent::_initialize();
		$name = str_replace('/Guides/', '', __ACTION__);
		if($name=='index'){
			$name = 'zfxz';
		}
		$guideInfo = M('guides')->where('gu_name="'.$name.'"')->find();
		if(empty($guideInfo)){
			$guideInfo = M('guides')->find();
		}
		$this->assign('guidesList', M('guides')->field('gu_name, gu_title')->select());
		$this->assign('article', $guideInfo);
		if($guideInfo['gu_template']){
			$this->display($guideInfo['gu_template']);
		}else{
			$this->display('Guides:article');
		}
		
		exit;
	
	}

}