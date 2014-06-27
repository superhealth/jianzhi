<?php
/**
 * 
 * @author Administrator
 *
 */
class AreaAction extends EmptyAction{

	/**
	 * 联动查找次级区域
	 */
	public function getSubArea($name=""){
		$subAreas = D("Area")->getSubAreas($name);
		if($subAreas){
			echo "<option value='no'>不限</option>";
			foreach($subAreas as $v){
				echo "<option value='{$v['name']}' >{$v['name']}</option>";
			}
		}else{
			echo "";
		}
		exit;
	}
}