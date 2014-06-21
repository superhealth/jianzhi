<?php
/**
 * 地区设置模块
 * @author Carl
 *
 */
class AreaAction extends BaseAction{
	/**
	 * 大区一栏
	 */
	public function index(){
		$area = M("area");
		$field = "a.area_id fid, a.area_name fname, a.area_order forder,a.area_reid freid, b.area_id sid, b.area_name sname, b.area_order sorder";
		$join = "a LEFT JOIN zt_area b ON a.area_id=b.area_reid";
		$areas = $area->field($field)->join($join)->where("a.area_reid=0")->order("forder, sorder")->select();
		foreach($areas as &$v){
			$v['subcount'] = M("area")->where("area_reid={$v['sid']}")->count();
			$areasNew[$v['fid']]['subs'][] = $v;
			if(!isset($areasNew[$v['fid']]['order'])){
				$areasNew[$v['fid']]['order'] = $v['forder'];
			}
			if(!isset($areasNew[$v['fid']]['name'])){
				$areasNew[$v['fid']]['name'] = $v['fname'];
			}
			if(!isset($areasNew[$v['fid']]['count'])){
				$areasNew[$v['fid']]['count'] = 0;
			}
			$areasNew[$v['fid']]['count']++;
		}
		$this->assign("areas", $areasNew);
		$this->display();
		
	}
	
	/**
	 * 添加主类
	 */
	public function add($id=0){
		if(!per_check("area_edit")){
			response_msg("无此权限！", "error", true);exit;
		}
		$responseHtml = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="area_reid" value="%id%" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>添加主类别</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label">所属区域</label>
					<div class="controls">
						 <h4>%name%</h4>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="area_name">区域名称</label>
					<div class="controls">
						 <input type="text" id="area_name" name="area_name" />
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="area_order">序号</label>
					<div class="controls">
					  	<input type="text" id="area_order" name="area_order" />
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="commit" data-act="%url%">保存</a>
			</div></fieldset></form>';
		$name = M("area")->where("area_id={$id}")->getField("area_name");
		if(empty($name)){
			$name = "主区域";
		}
		echo str_replace(array("%id%","%name%","%url%"), array($id,$name,__URL__."/save"), $responseHtml);
	}
	
	/**
	 * 保存区域
	 */
	public function save(){
		if(!per_check("area_edit")){
			$this->error("无此权限！");
		}else{
			$data = M("area")->create();
			if(M("area")->add($data)){
				$this->watchdog("新增", "增加区域 <strong>{$data['area_name']}</strong>");
				$this->success("保存成功！", __URL__."/index");
			}else{
				$this->error("保存失败！");
			}
		}
	}
	
	/**
	 * ajax 编辑地区信息
	 */
	public function modify(){
		$data = M("area")->create();
		if(M("area")->save($data)){
			$this->watchdog("编辑", "修改【{$data['area_name']}】地区属性。");
			echo "oK";
		}else{
			echo "error";
		}
	}
}

?>