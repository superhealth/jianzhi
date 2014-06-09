<?php
class IndexAction extends BaseAction{
	/* 首页 */
	public function index(){
		$this->display();
	}
	
	/**
	 * banners
	 */
	public function banners(){
		$banners = M("banner")->order("ba_order")->select();
		$this->assign("banners", $banners);
		$advertise = M("advertise")->where("ad_name='indexadv'")->select();
		$this->assign("advertise", $advertise);
		$this->display();
	}
	public function banner_add($action=""){
		if($action=="save"){
			if(!per_check("banner_manger")){
				$msg = response_msg("ACCESS_DENIED");
				
			}else{
				$data = M("banner")->create();
				if(!is_numeric($data['ba_order'])){
					$max_id = M("banner")->order("ba_id DESC")->limit(1)->getField("ba_id");
					$data['ba_order'] = $max_id+1;
				}
				$info = $this->uploadImg();
				if($info[0]){
					$data['ba_src'] = $info[1][0]['savename'];
					if(M("banner")->add($data)){
						$this->watchdog("新增", "添加新的首页banner{$data['ba_title']}");
						$msg = response_msg("OPERATION_SUCCESS", "success");
					}else{
						$msg = response_msg("OPERATION_FAILED");
					}
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}
			redirect(__URL__."/banners/msg/{$msg}");exit;
		}else{
			if(!per_check("banner_manger")){
				echo response_msg("操作受限！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加banner</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="ba_src">banner图片<br /> 1920&times;*</label>
						<div class="controls">
							 <input type="file" class="input-file uniform_on" id="ba_src" name="ba_src" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_title">banner标题</label>
						<div class="controls">
							 <input type="text" id="ba_title" name="ba_title" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_alt">banner描述</label>
						<div class="controls">
							 <input type="text" id="ba_alt" name="ba_alt" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_href">banner链接</label>
						<div class="controls">
							 <input type="text" id="ba_href" name="ba_href" value="http://" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_order">播放次序</label>
						<div class="controls">
							 <input type="text" id="ba_order" name="ba_order" style="width:40px;" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="banner_commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			$url = __URL__."/banner_add";
			echo str_replace(array("%url%"), array($url), $responseHTML);
		}
	}
	public function banner_edit($action=""){
		if($action=="save"){
			if(!per_check("banner_manger")){
				$msg = response_msg("ACCESS_DENIED");
			}
			$data = M("banner")->create();
			if(!is_numeric($data['ba_order'])){
				unset($data['ba_order']);
			}
			$flag = false;
			foreach($_FILES as $v){
				if($v['name'] !=""){
					$flag = true;
					break;
				}
			}
			if($flag){
				$info = $this->uploadImg();
				if($info[0]){
					$data['ba_src'] = $info[1][0]['savename'];
					$old_banner = M("banner")->where("ba_id={$data['ba_id']}")->getField("ba_src");
				}else{
					$msg = response_msg("OPERATION_FAILED");
					redirect(__URL__."/banners/msg/{$msg}");exit;
				}
			}
			if(M("banner")->save($data)){
				$this->watchdog("编辑", "修改首页banner{$data['ba_title']}");
				if(isset($old_banner)&&$old_banner!=""){
					$this->delOldImg($old_banner);
				}
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
			redirect(__URL__."/banners/msg/{$msg}");
		}else{
			if(!per_check("banner_manger")){
				echo response_msg("操作受限！", "error", true);
				exit;
			}
			$ba_id = $_REQUEST['ba_id'];
			$banner_info = M("banner")->where("ba_id={$ba_id}")->find();
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />	
				<input type="hidden" name="ba_id" value="%ba_id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改banner</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="ba_src">banner图片<br /> 1920&times;*</label>
						<div class="controls">
							<img src="%src%" style="height:40px;" /><br />
							<input type="file" class="input-file uniform_on" id="ba_src" name="ba_src" />
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_title">banner标题</label>
						<div class="controls">
							 <input type="text" id="ba_title" name="ba_title" value="%title%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_alt">banner描述</label>
						<div class="controls">
							 <input type="text" id="ba_alt" name="ba_alt" value="%alt%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_href">banner链接</label>
						<div class="controls">
							 <input type="text" id="ba_href" name="ba_href" value="%href%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_order">播放次序</label>
						<div class="controls">
							 <input type="text" id="ba_order" name="ba_order" style="width:40px;" value="%order%" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="banner_commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			echo str_replace(array("%ba_id%", "%src%", "%title%", "%alt%", "%href%", "%order%","%url%"), array($banner_info['ba_id'],__ROOT__."/uploads/".$banner_info['ba_src'],$banner_info['ba_title'],$banner_info['ba_alt'], $banner_info['ba_href'], $banner_info['ba_order'], __URL__."/banner_edit"), $responseHTML);
		}
	}
	public function banner_delete($chkt =""){
		if(!per_check("banner_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}elseif((is_array($chkt)&&count($chkt)==0)||$chkt==""){
			$msg = response_msg("INVALID_ARGUMENT");
		}else{
			$map = array("ba_id"=>array("in", $chkt));
			$banners = M("banner")->where($map)->select();
			if(M("banner")->where($map)->delete()){
				$this->watchdog("删除", "删除banner:". implode(", ", $banners['ba_title']));
				$msg = response_msg("OPERATION_SUCCESS", "success");
				foreach($banners as $v){
					$this->delOldImg($v['ba_src']);
				}
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/banners/msg/{$msg}");
	}
	
	/**
	 * 
	 * @param string $action
	 */
	public function advertise_edit($action=""){
		if($action=="save"){
			if(!per_check("banner_manger")){
				$msg = response_msg("无此权限！", "error", true);
			}else{
				$data = M("advertise")->create();
				if(!is_numeric($data['ad_order'])){
					unset($data['ad_order']);
				}
				$flag = false;
				foreach($_FILES as $v){
					if($v['name'] !=""){
						$flag = true;
						break;
					}
				}
				if($flag){
					$info = $this->uploadImg();
					if($info[0]){
						$data['ad_img'] = $info[1][0]['savename'];
						$old_banner = M("advertise")->where("ad_id={$data['ad_id']}")->getField("ad_src");
					}else{
						$msg = response_msg("UPLOAD_FAILED");
						redirect(__URL__."/banners/msg/{$msg}");exit;
					}
				}
				if(M("advertise")->save($data)){
					$this->watchdog("编辑", "修改首页banner{$data['ba_title']}");
					if(isset($old_banner)&&$old_banner!=""){
						$this->delOldImg($old_banner);
					}
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}
			redirect(__URL__."/banners/msg/{$msg}");
		}else{
			if(!per_check("banner_manger")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			$id = $_REQUEST['ad_id'];
			$info = M("advertise")->where("ad_id={$id}")->find();
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="ad_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改广告链接</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="ad_img">广告图片<br /> 1920&times;*</label>
						<div class="controls">
							<img src="%src%" style="height:40px;" /><br />
							<input type="file" class="input-file uniform_on" id="ad_img" name="ad_img" />
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ad_title">广告标题</label>
						<div class="controls">
							 <input type="text" id="ad_title" name="ad_title" value="%title%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ad_alt">广告描述</label>
						<div class="controls">
							 <input type="text" id="ad_alt" name="ad_alt" value="%alt%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ad_href">广告链接</label>
						<div class="controls">
							 <input type="text" id="ad_link" name="ad_link" value="%href%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ad_lang">语种</label>
						<div class="controls">
							 <input type="text" id="ad_lang" name="ad_lang" value="%lang%" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="banner_commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			echo str_replace(array("%id%", "%src%", "%title%", "%alt%", "%href%", "%lang%","%url%"), array($info['ad_id'],__ROOT__."/uploads/mi_".$info['ad_img'],$info['ad_title'],$info['ad_alt'], $info['ad_link'], $info['ad_lang'], __URL__."/advertise_edit"), $responseHTML);
		}
	}
	
	
	/**
	 * sliders
	 */
	public function sliders(){
		$map = array();
		$param = array();
		if(isset($_REQUEST['grp']) && $_REQUEST['grp']!="all" ){
			$map['sl_group']  = $_REQUEST['grp'];
			$param['grp'] = $_REQUEST['grp'];
		}
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['sl_title']  = array('like', "%{$words}%");
				$where['sl_alt']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$this->assign("group", array("group1"=>"group1", "group2"=> "group2"));
		$sliders = M("slider")->where($map)->order("sl_group, sl_order")->select();
		//换色
		if(!empty($param['words'])){
			foreach($sliders as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("sliders", $sliders);
		$this->display();
	}
	public function slider_add($action=""){
		if($action=="save"){
			if(!per_check("slider_manger")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$data = M("slider")->create();
				if(!is_numeric($data['sl_order'])){
					$max_id = M("slider")->order("sl_id DESC")->limit(1)->getField("sl_id");
					$data['sl_order'] = $max_id+1;
				}
				$info = $this->uploadImg();
				if($info[0]){
					$data['sl_src'] = $info[1][0]['savename'];
					if(M("slider")->add($data)){
						$this->watchdog("新增", "添加新的轮播图片{$data['sl_title']}");
						$msg = response_msg("OPERATION_SUCCESS", "success");
					}else{
						$msg = response_msg("OPERATION_FAILED");
					}
				}else{
					$msg = response_msg("UPLOAD_FAILED");
				}
			}
			redirect(__URL__."/sliders/msg/{$msg}");exit;
		}else{
			if(!per_check("slider_manger")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加首页轮播产品</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sl_src">产品图片<br />204&times;120</label>
						<div class="controls">
							 <input type="file" class="input-file uniform_on" id="sl_src" name="sl_src" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_title">图片标题</label>
						<div class="controls">
							 <input type="text" id="sl_title" name="sl_title" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_alt">图片描述</label>
						<div class="controls">
							 <input type="text" id="sl_alt" name="sl_alt" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_href">图片链接</label>
						<div class="controls">
							 <input type="text" id="sl_href" name="sl_href" value="http://" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_href">轮播分组</label>
						<div class="controls">
							<select id="sl_group" name="sl_group">
								<option>group1</option>	
								<option>group2</option>	
							</select>
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_order">播放次序</label>
						<div class="controls">
							 <input type="text" id="sl_order" name="sl_order" style="width:40px;" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="slider_commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
				
			echo str_replace(array("%url%"), array(__URL__."/slider_add"), $responseHTML);
		}
	}
	/**
	 * 
	 * @param string $action
	 */
	public function slider_edit($action=""){
		if($action=="save"){
			if(!per_check("slider_manger")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$data = M("slider")->create();
				if(!is_numeric($data['sl_order'])){
					unset($data['sl_order']);
				}
				$flag = false;
				foreach($_FILES as $v){
					if($v['name'] !=""){
						$flag = true;
						break;
					}
				}
				if($flag){
					$info = $this->uploadImg();
					if($info[0]){
						$data['sl_src'] = $info[1][0]['savename'];
						$old_slider = M("slider")->where("sl_id={$data['sl_id']}")->getField("sl_src");
					}else{
						$msg = response_msg("UPLOAD_FAILED");
						redirect(__URL__."/sliders/msg/{$msg}");exit;
					}
				}
				if(M("slider")->save($data)){
					$this->watchdog("编辑", "修改首页轮播图{$data['sl_title']}");
					if(isset($old_slider)&&$old_slider!=""){
						$this->delOldImg($old_slider);
					}
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}
			redirect(__URL__."/sliders/msg/{$msg}");
		}else{
			if(!per_check("slider_manger")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			$sl_id = $_REQUEST['sl_id'];
			$slider_info = M("slider")->where("sl_id={$sl_id}")->find();
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="sl_id" value="%sl_id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加首页轮播产品</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="sl_src">产品图片<br />204&times;120</label>
						<div class="controls">
							<img src="%src%" style="height:40px;" /><br /> 
							<input type="file" class="input-file uniform_on" id="sl_src" name="sl_src" />
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_title">图片标题</label>
						<div class="controls">
							 <input type="text" id="sl_title" name="sl_title" value="%title%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_alt">图片描述</label>
						<div class="controls">
							 <input type="text" id="sl_alt" name="sl_alt" value="%alt%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_href">图片链接</label>
						<div class="controls">
							 <input type="text" id="sl_href" name="sl_href" value="%href%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_href">轮播分组</label>
						<div class="controls">
							<select id="sl_group" name="sl_group">
								%options%	
							</select>
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sl_order">播放次序</label>
						<div class="controls">
							 <input type="text" id="sl_order" name="sl_order" style="width:40px;" value="%order%" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="slider_commit" data-act="%url%">修改</a>
				</div></fieldset></form>';
			$options = "";
			$grp_ary = array("group1", "group2");
			foreach($grp_ary as $opt){
				if($slider_info['sl_group'] == $opt){
					$options .= "<option selected='selected'>".$opt."</option>";
				}else{
					$options .= "<option>".$opt."</option>";
				}
			}
			echo str_replace(array("%sl_id%", "%src%", "%title%", "%alt%", "%href%", "%options%", "%order%", "%url%"), array($slider_info['sl_id'], __ROOT__."/uploads/".$slider_info['sl_src'], $slider_info['sl_title'], $slider_info['sl_alt'], $slider_info['sl_href'], $options,  $slider_info['sl_order'], __URL__."/slider_edit"), $responseHTML);
		}
	}
	public function slider_delete($chkt =""){
		if(!per_check("slider_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}elseif((is_array($chkt)&&count($chkt)==0)||$chkt==""){
			$msg = response_msg("INVALID_ARGUMENT");
		}else{
			$map = array("sl_id"=>array("in", $chkt));
			$sliders = M("slider")->where($map)->select();
			if(M("slider")->where($map)->delete()){
				$this->watchdog("删除", "删除slider:". implode(", ", $sliders['sl_title']));
				$msg = response_msg("OPERATION_SUCCESS", "success");
				foreach($sliders as $v){
					$this->delOldImg($v['sl_src']);
				}
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/sliders/msg/{$msg}");
	}
	
	/**
	 * useradv
	 */
	public function useradv(){
		$useradv = M("useradv")->order("um_order")->select();
		$this->assign("useradv", $useradv);
		$this->display();
	}
	
	public function useradv_add($action=""){
		if($action=="save"){
			if(!per_check("useradv_manger")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$data = M("useradv")->create();
				if(!is_numeric($data['um_order'])){
					$max_id = M("useradv")->order("um_id DESC")->limit(1)->getField("um_id");
					$data['um_order'] = $max_id+1;
				}
				$info = $this->uploadAdvs();
				if($info[0]){
					$data['um_src'] = $info[1][0]['savename'];
					if(M("useradv")->add($data)){
						$this->watchdog("新增", "添加新的用户广告{$data['ba_title']}");
						$msg = response_msg("OPERATION_SUCCESS", "success");
					}else{
						$msg = response_msg("OPERATION_FAILED");
					}
				}else{
					$msg = response_msg("UPLOAD_FAILED");
				}
			}
			redirect(__URL__."/useradv/msg/{$msg}");exit;
		}else{
			if(!per_check("useradv_manger")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>添加用户中心广告</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="um_src">banner图片<br /> 900&times;*</label>
						<div class="controls">
							 <input type="file" class="input-file uniform_on" id="um_src" name="um_src" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_title">banner标题</label>
						<div class="controls">
							 <input type="text" id="um_title" name="um_title" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_alt">banner描述</label>
						<div class="controls">
							 <input type="text" id="um_alt" name="um_alt" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_link">banner链接</label>
						<div class="controls">
							 <input type="text" id="um_link" name="um_link" value="http://" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_order">播放次序</label>
						<div class="controls">
							 <input type="text" id="um_order" name="um_order" style="width:40px;" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="useradv_commit" data-act="%url%">添加</a>
				</div></fieldset></form>';
			$url = __URL__."/useradv_add";
			echo str_replace(array("%url%"), array($url), $responseHTML);
		}
	}
	public function useradv_edit($action=""){
		if($action=="save"){
			if(!per_check("useradv_manger")){
				$msg = response_msg("ACCESS_DENIED");
			}else{
				$data = M("useradv")->create();
				if(!is_numeric($data['um_order'])){
					unset($data['um_order']);
				}
				$flag = false;
				foreach($_FILES as $v){
					if($v['name'] !=""){
						$flag = true;
						break;
					}
				}
				if($flag){
					$info = $this->uploadAdvs();
					if($info[0]){
						$data['um_src'] = $info[1][0]['savename'];
						$old_img = M("useradv")->where("um_id={$data['um_id']}")->getField("um_src");
					}else{
						$msg = response_msg("UPLOAD_FAILED");
						redirect(__URL__."/useradv/msg/{$msg}");exit;
					}
				}
				if(M("useradv")->save($data)){
					$this->watchdog("编辑", "修改用户广告{$data['um_title']}");
					if(isset($old_img)&&$old_img!=""){
						$this->delOldImg("big_".$old_img);
						$this->delOldImg("mi_".$old_img);
					}
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}
			redirect(__URL__."/useradv/msg/{$msg}");
		}else{
			if(!per_check("useradv_manger")){
				echo response_msg("无此权限！", "error", true);
				exit;
			}
			$id = $_REQUEST['um_id'];
			$info = M("useradv")->where("um_id={$id}")->find();
			$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="um_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>修改用户广告%title%</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="um_src">广告图片<br /> &times;*</label>
						<div class="controls">
							<img src="%src%" style="height:40px;" /><br />
							<input type="file" class="input-file uniform_on" id="um_src" name="um_src" />
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_title">广告标题</label>
						<div class="controls">
							 <input type="text" id="um_title" name="um_title" value="%title%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_alt">广告描述</label>
						<div class="controls">
							 <input type="text" id="um_alt" name="um_alt" value="%alt%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_link">广告链接</label>
						<div class="controls">
							 <input type="text" id="um_link" name="um_link" value="%href%" />
							 <span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="um_order">次序</label>
						<div class="controls">
							 <input type="text" id="um_order" name="um_order" style="width:40px;" value="%order%" />
							 <span class="help-inline"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="useradv_commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			echo str_replace(array("%id%", "%src%", "%title%", "%alt%", "%href%", "%order%","%url%"), array($info['um_id'],__ROOT__."/uploads/".$info['um_src'],$info['um_title'],$info['um_alt'], $info['um_link'], $info['um_order'], __URL__."/useradv_edit"), $responseHTML);
		}
	}
	public function useradv_delete($chkt =""){
		if(!per_check("useradv_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}elseif((is_array($chkt)&&count($chkt)==0)||$chkt==""){
			$msg = response_msg("INVALID_ARGUMENT");
		}else{
			$map = array("um_id"=>array("in", $chkt));
			$userdavs = M("useradv")->where($map)->select();
			if(M("useradv")->where($map)->delete()){
				$this->watchdog("删除", "删除用户中心广告:". implode(", ", $userdavs['um_title']));
				$msg = response_msg("OPERATION_SUCCESS", "success");
				foreach($userdavs as $v){
					$this->delOldImg("big_".$v['um_src']);
					$this->delOldImg("mi_".$v['um_src']);
				}
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/useradv/msg/{$msg}");
	}
	
	private function uploadAdvs(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->thumb = true;							//是否生成缩略图
		$upload->thumbFlag = true;					//true为等比缩放输出，false按照设定大小输出
		$upload->thumbMaxWidth = '143,900';			//缩略图最大宽度
		$upload->thumbMaxHeight = '193,1048';			//缩略图最大高度
		$upload->thumbPrefix = 'mi_,big_';					//缩略图前缀
		$upload->uploadReplace = false;
		$upload->maxSize  = 3145728*1024 ;				// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'pdf', 'txt');		// 设置附件上传类型
		$upload->savePath = './uploads/';	// 设置附件上传目录
		if(!$upload->upload()) {
			$info[] = false;
			$info[] = $upload->getErrorMsg();	// 上传错误提示错误信息
		}else{
			$info[] = true;
			$info[] = $upload->getUploadFileInfo();	// 上传成功 获取上传文件信息
		}
		return $info;
	}
	
	
	/*  */
	public function logout(){
		unset($_SESSION['user']);
		redirect(__GROUP__."/Login");
	}
	
	/**
	 * 招聘
	 */
	public function employe(){
		$map = array();
		$param = array();
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['em_name']  = array('like', "%{$words}%");
				$where['em_duty']  = array('like',"%{$words}%");
				$where['em_qualify']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = M("employe")->where($map)->count();
		import("Org.Util.Page");
		$page = new Page($total, 16, $param);
		// 分页查询
		$limit = $page->firstRow.",".$page->listRows;
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$order = "em_order DESC,em_addtime DESC";
		$emplyes = M("employe")->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($emplyes as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("employes", $emplyes);
		$this->display();
	}
	/**
	 * 添加
	 */
	public function employe_add(){
		if(!per_check("employe_manger")){
			echo response_msg("Access_Denied!", "error", true);
			exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="add" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>增加招聘职位</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="em_name">职位名称</label>
					<div class="controls">
						 <input type="text" id="em_name" name="em_name" />
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_order">显示次序</label>
					<div class="controls">
					  	<input type="text" id="em_order" name="em_order" />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_lang">语种</label>
					<div class="controls">
					  	<input type="text" id="em_lang" name="em_lang" />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_duty">岗位职责</label>
					<div class="controls">
					  	<textarea name="em_duty" id="em_duty" style="width:320px;height:100px;"></textarea>
						<br /><span>不同条目用“|”隔开</span><br />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_qualify">任职资格</label>
					<div class="controls">
					  	<textarea name="em_qualify" id="em_qualify" style="width:320px;height:100px;"></textarea>
						<br /><span>不同条目用“|”隔开</span><br />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_public">是否发布</label>
					<div class="controls">
					  	<input type="checkbox" checked name="em_public" id="em_public" value="1" />
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="employe_commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
		$url = __URL__."/employe_save";
		echo str_replace("%url%", $url, $responseHTML);
	}
	/**
	 * 保存
	 */
	public function employe_save(){
		if(!per_check("employe_manger")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$data = M("employe")->create();
			$data['em_addtime'] = time();
			if(!is_numeric($data["em_order"])){
				$lastestId = M("employe")->order("em_id DESC")->limit(1)->getField("em_id");
				$data['em_order'] = $lastestId+1;
			}
			if(M("employe")->add($data)){
				$this->watchdog("新增", "增加招聘职位《{$data['em_name']}》！");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED".M("desktop")->getError());
			}
		}
		redirect(__URL__."/employe/msg/{$msg}");
	}
	/**
	 * 查看
	 * @param string $man_id
	 */
	public function employe_edit($em_id=""){
		if(!per_check("employe_manger")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$responseHTML = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="em_id" value="%em_id%" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>修改职位信息</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="em_name">职位名称</label>
					<div class="controls">
						 <input type="text" id="em_name" name="em_name" value="%em_name%" />
						 <span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_order">显示次序</label>
					<div class="controls">
					  	<input type="text" id="em_order" name="em_order" value="%em_order%" />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_lang">语种</label>
					<div class="controls">
					  	<input type="text" id="em_lang" name="em_lang" value="%em_lang%" />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_duty">岗位职责</label>
					<div class="controls">
					  	<textarea name="em_duty" id="em_duty" style="width:320px;height:100px;">%em_duty%</textarea>
						<br /><span>不同条目用“|”隔开</span><br />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_qualify">任职资格</label>
					<div class="controls">
					  	<textarea name="em_qualify" id="em_qualify" style="width:320px;height:100px;">%em_qualify%</textarea>
						<br /><span>不同条目用“|”隔开</span><br />
					  	<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="em_public">是否发布</label>
					<div class="controls">
					  	<input type="checkbox" %em_public% name="em_public" id="em_public" value="1" />
					  	<span class="help-inline"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<a href="#" class="btn btn-primary" id="employe_commit" data-act="%url%">上传</a>
			</div></fieldset></form>';
		$info = M("employe")->where("em_id={$em_id}")->find();
		if(empty($info)){
			echo response_msg("Invalid Arguments!", "error", true);
			exit;
		}
		$url = __URL__."/employe_modify";
		echo str_replace(array("%em_id%", "%em_name%", "%em_order%", "%em_lang%","%em_duty%","%em_qualify%","%em_public%","%url%"), array($info['em_id'], $info['em_name'], $info['em_order'], $info['em_lang'], $info['em_duty'], $info['em_qualify'], $info['em_public']==1?'checked':'', $url), $responseHTML);
	
	}
	/**
	 * 保存修改
	 */
	public function employe_modify(){
		if(!per_check("employe_manger")){
			$msg = response_msg("ACCESS_DENIED!");
		}else{
			$data = M("employe")->create();
			if(!is_numeric($data['em_order'])){
				unset($data['em_order']);
			}
			if(M("employe")->save($data)){
				$this->watchdog("编辑", "修改招聘职位{$data['em_name']}");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/employe/msg/{$msg}");
	}
	/**
	 * 删除
	 * @param string $chkt
	 */
	public function employe_delete($chkt=""){
		if(!per_check("employe_manager")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			if(!is_array($chkt)){
				$chkt = array($chkt);
			}
			$map = array("em_id"=>array("in", $chkt));
			$employes = M("employe")->where($map)->getField("em_name", true);
			if(M("employe")->where($map)->delete()){
				$this->watchdog("删除", "删除手册".implode(",", $employes));
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/employe/msg/{$msg}");
	}
	
	
	
	
}