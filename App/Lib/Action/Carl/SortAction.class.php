<?php
class SortAction extends BaseAction{
	/**
	 * 所有分类
	 */
	public function index(){
		
		$sorts = M("sort")->select();
		$this->assign("sorts", $sorts);
		$this->display();
	}
	
	/**
	 * 添加主类
	 */
	public function sort_add($action=""){
		if($action=="add"){
			if(!per_check("sort_edit")){
				$this->error("无此权限！");
			}
			$data = M("sort")->create();
			if(M("sort")->add($data)){
				$this->watchdog("新增", "添加新主类：{$data['sort_name']}");
				$this->success("添加成功！");
			}else{
				$this->error("添加失败！");
			}
		}else{
			if(!per_check("sort_edit")){
				response_msg("无此权限！", "error", true);exit;
			}
			$responseHtml = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加主类别</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sort_name">类别名称</label>
						<div class="controls">
							 <input type="text" id="sort_name" name="sort_name" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sort_order">显示次序</label>
						<div class="controls">
						  	<input type="text" id="sort_order" name="sort_order" />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHtml);
		}
	}
	
	/**
	 * 编辑主类
	 */
	public function sort_edit($action=""){
		if($action=="edit"){
			
		}else{
			
		}
	}
	
	/**
	 * 删除主类
	 * @param string $chkt 选中的ID
	 */
	public function sort_delete($chkt=""){
		
	}
	/**
	 * 主类详细信息
	 * @param string $id 主类ID
	 */
	public function sort_info($id=""){
	
	}
	/**
	 * 添加类型
	 * @param string $action 
	 */
	public function enum_add($action=""){
		if($action=="add"){
			
		}else{
			
		}
	}
	/**
	 * 编辑类型
	 * @param string $action 
	 */
	public function enum_edit($action=""){
		if($action=="edit"){
			
		}else{
			
		}
	}
	/**
	 * 删除类型
	 * @param string $chkt
	 */
	public function enum_delete($chkt=""){
		
	}
	
	
	
}

?>