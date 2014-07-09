<?php
/**
 * 税费管理模块
 * @author dapianzi
 *
 */
class TaxesAction extends BaseAction{
	/**
	 * 所有生产属性
	 */
	public function index(){
		$taxes = M("taxes")->select();
		$this->assign("taxes", $taxes);
		$this->display();
	}
	
	/**
	 * 添加税费属性
	 * @param string $action 
	 */
	public function add($action=""){
		if($action=="add"){
			if(!per_check("taxes_edit")){
				$this->error("无此权限！");
			}
			$data = M("taxes")->create();
			if(M("taxes")->add($data)){
				$this->watchdog("新增", "添加税费选项 <strong>{$data['tax_name']}</strong>");
				$this->success("添加成功！", __URL__."/index");
			}else{
				$this->error("添加失败！");
			}
		}else{
			if(!per_check("taxes_edit")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
				
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="add" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>新增税费选项</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="tax_name">税费名称</label>
						<div class="controls">
							 <input type="text" id="tax_name" name="tax_name" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tax_value">税费百分比</label>
						<div class="controls">
						  	<input type="text" name="tax_value" id="tax_value" />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tax_desc">税费说明</label>
						<div class="controls">
						  	<textarea name="tax_desc" id="tax_desc"></textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHTML);
		}
	}
	
	/**
	 * 修改税费选项
	 * @param string $action
	 */
	public function edit($action = ""){
		if($action=="edit"){
			if(!per_check("taxes_edit")){
				$this->error("无此权限！");
			}
			else{
				$data = M("taxes")->create();
				if(M("taxes")->save($data)){
					$this->watchdog("编辑", "修改税费选项 {$data['tax_name']}");
					$this->success("保存成功！", __URL__."/index");
				}else{
					$this->error("保存失败！");
				}
			}
		}else{
			if(!per_check("taxes_edit")){
				echo response_msg("无此权限!", "error", true);
				exit;
			}
			if(!isset($_REQUEST['id'])){
				echo response_msg("参数错误！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="edit" />
				<input type="hidden" name="tax_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改税费选项</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="tax_name">税费名称</label>
						<div class="controls">
							 <input type="text" id="tax_name" name="tax_name" value="%name%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tax_value">税费百分比</label>
						<div class="controls">
						  	<input type="text" name="tax_value" id="tax_value" size="8" value="%value%" />%
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="tax_desc">税费说明</label>
						<div class="controls">
						  	<textarea name="tax_desc" id="tax_desc">%desc%</textarea>
							<br />
						  	<span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$info = M("taxes")->where("tax_id={$_REQUEST['id']}")->find();
			if(empty($info)){
				echo response_msg("参数错误!", "error", true);
				exit;
			}
			echo str_replace(array("%id%", "%name%","%value%", "%desc%", "%url%"), array($info['tax_id'], $info['tax_name'], $info['tax_value'], $info['tax_desc'], __ACTION__), $responseHTML);
		}
	}
	
	/**
	 * 删除税费选项
	 * @param string $id
	 */
	public function delete($id=""){
		if(!per_check("taxes_edit")){
			$this->error("无此权限！");
		}else{
			$map = array("tax_id"=>array("in", $id));
			$taxes = M("taxes")->where($map)->getField("tax_name", true);
			$detail = "删除税费选项：".implode(",", $taxes);
			if(M("taxes")->where($map)->delete()){
				$this->watchdog("删除", $detail);
				$this->success("删除成功！");
			}else{
				$this->error("删除失败！");
			}
		}
	}
	
	/**
	 * 更新缓存
	 */
	public function update(){
		if(!per_check("taxes_edit")){
			$this->error("无此权限！");
		}
		if(D("Taxes")->updateCache()){
			$this->success("更新成功！");
		}else{
			$this->error("更新失败！");
		}
	}
}