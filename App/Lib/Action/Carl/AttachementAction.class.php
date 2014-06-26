<?php
/**
 * 附件管理模块
 * @author Carl
 *
 */
class AttachementAction extends BaseAction{
	public function index(){
		$attach = M("attachement");
		$param = array();
		$map = array();
		if(isset($_REQUEST['att_type']) && $_REQUEST['att_type'] != "all"){
			$map['att_type'] = $_REQUEST['att_type'];
			$param['att_type'] = $_REQUEST['att_type'];
		}
		if(isset($_REQUEST['words'])){
			$word = strip_tags($_REQUEST['words']);
			if(strlen($word>=3 && $_REQUEST['filter'] != "all")){
				$map[$_REQUEST['filter']] = array("like", "%{$word}%");
				$param['filter'] = $_REQUEST['filter'];
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		// total
		$total = $attach->join()->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 10, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		//查询结果
		$order = "att_time DESC";
		$field = "att_id, att_name, att_type, att_size, att_time, att_mid";
		$atts = $attach->field($field)->where($map)->order($order)->limit($limit)->select();
		$this->assign("atts", $atts);
		$type = $attach->group("att_type")->getField("att_type,att_type type", true);
		$this->assign("filter", array("att_name"=>"附件名称","att_mid"=>"附件作者"));
		$this->assign("type", $type);
		$this->display();
	}
	
	public function add($action=""){
		if($action=="add"){
			if(!per_check("attach_edit")){
				$msg = response_msg("ACCESS_DENIED");
				$this->error("无此权限！");
			}
			$name = empty($_POST['att_name']) ? "" : $_POST['att_name'];
			//上传文件
			$uploadInfo = upload($_SESSION['user'],false, $name);
			if($uploadInfo[0]){
				$att_data = array(
						'att_name'	=> $uploadInfo[1][0]['savename'],
						'att_path'	=> trim($uploadInfo[1][0]['savepath'],".").$uploadInfo[1][0]['savename'],
						'att_type'	=> $uploadInfo[1][0]['extension'],
						'att_size'	=> getFileSize($uploadInfo[1][0]['size']),
						'att_mid'		=> $_SESSION['user'],
						'att_time'	=> time()
				);
				if(M("attachement")->add($att_data)){
					$this->watchdog("新增", "上传附件{$att_data['att_name']}");
					$this->success("附件添加成功！", __URL__."/index");
				}else{
					fileDelete($att_data['att_name']);
					$this->error("附件保存失败");
				}
			}else{
				$this->error("上传失败！".$uploadInfo[1]);
			}
		}else{
			if(!per_check("attach_edit")){
				echo response_msg("Access_Denied!", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="add" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>上传附件</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="attache">选择附件</label>
					<div class="controls">
						 <input type="file" id="attache" name="attache" />
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="att_name">附件名称</label>
					<div class="controls">
					  	<input type="text" name="att_name" id="att_name" />
						<br /><span>留空保留原文件名</span><br />
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
			echo str_replace("%url%", __ACTION__, $responseHTML);
		}
	}
	
	/**
	 * 删除附件
	 * @param string $chkt
	 */
	public function del($chkt=""){
		if(!per_check("attach_edit")){
 			$this->error("无此权限！");
		}
		if(!empty($chkt)||(is_array($chkt)&&count($chkt)>0)){
			if(attDelete($chkt)===true){
				$this->watchdog("删除", "删除附件");
				$this->success("删除成功！", __URL__."/index");
			}else{
				$this->error("删除失败！");
			}
		}else{
			$this->error("参数错误！");
		}
	}
	
	/**
	 * 下载附件
	 * @param string $id
	 */
	public function download($id=""){
		$attach = M("attachement")->where("att_id={$id}")->find();
		if($attach){
			$download = attDownload($attach['att_path'], $attach['att_name']);
			if($download!==true){
				$this->closeWin = true;
				$this->error("下载失败：{$download}");
			}
		}else{
			$this->error("附件不存在！");
		}
	}
	
}