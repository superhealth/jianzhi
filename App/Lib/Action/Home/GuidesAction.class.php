<?php
class GuidesAction extends CommonAction{
	
	public function _initialize(){
		parent::_initialize();
		$name = str_replace('/Guides/', '', __ACTION__);
		if($name=='index'){
			$name = 'zfxz';
		}
		$guideInfo = M('guides')->where('gd_name="'.$name.'"')->find();
		if(!empty($guideInfo)){
			$this->assign('guide', $guideInfo);
			$this->display('Guides:guide');
			exit;
		}
	
	}

}