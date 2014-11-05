<?php 
/**
 * 分类广告项目数据模型
 * @author Carl
 *
 */
class SortadvModel extends Model{
	
	public function getSortAdvs($sortid, $num=5){
		
		$join = 'LEFT JOIN zt_project ON sa_pro=pro_id';
		$where = array(
				'sa_sort'	=> $sortid,
		);
		$sortAdvs =  $this->field('')->join($join)->where($where)->order('sa_order')->limit($num)->select();
		foreach($sortAdvs as &$v){
			$v['pro_place'] = str_replace(array('|','中国','省','市'),array('','',' ',' '), $v['pro_place']);
		}
		return $sortAdvs;
		
		
	}
	
	
	
}



?>