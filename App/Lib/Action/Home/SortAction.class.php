<?php 
class SortAction extends EmptyAction{
	public function getEnums($sortid){
		echo enumsToSelect($sortid);
	}
}



?>