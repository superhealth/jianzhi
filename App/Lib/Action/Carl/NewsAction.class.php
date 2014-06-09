<?php
class NewsAction extends BaseAction{
	public function index(){
		$news = M("news");
		$param = array();
		$map = array();
		// 过滤选项
		if(isset($_REQUEST['words'])){
			$words = addslashes($_REQUEST['words']);
			if(strlen($words)>=3){
				$where['ne_title']  = array('like', "%{$words}%");
				$where['ne_author']  = array('like',"%{$words}%");
				$where['ne_summary']  = array('like', "%{$words}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		
		$this->assign("param", $param);
		// total总数
		$total = $news->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		//排序规则
		$order = "ne_top DESC, ne_time DESC";
		$field = "ne_id,ne_top, ne_title, ne_time, ne_author, ne_summary, ne_publish";
		$news_list = $news->field($field)->where($map)->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($news_list as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("news_edit", per_check("news_edit"));
		$this->assign("state", array("隐藏", "显示"));
		$this->assign("news_list", $news_list);
		$this->display();
	}
	
	public function newstopic(){
		$join = "chuango_news ON nt_news=ne_id";
		$index = M("newstopic")->join($join)->where("nt_page='index'")->order("nt_order")->select();
		$news = M("newstopic")->join($join)->where("nt_page='news'")->order("nt_order")->select();
		$this->assign("news", $news);
		$this->assign("index", $index);
		$this->display();
	}
	
	public function news_add($action=""){
		if(!per_check("news_add")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			if($action=="add"){
				$news = M("news");
				$news_data = $news->create();
				// 相关产品
				$news_data['ne_relatepro'] = implode(",", $news_data['ne_relatepro']);
				$news_data['ne_time'] = strtotime($news_data['ne_time']);
				if(!isset($news_data['ne_publish'])){
					$news_data['ne_publish'] = "off";
				}
				if(!isset($news_data['ne_top'])){
					$news_data['ne_top'] = "off";
				}
				$contents = $_POST['ne_content'];
				foreach($contents as $k=>$v){
					$data = array(
						"nec_content" => addslashes($v),
						"nec_order"=>$k
					);
					$subContentId = M("newscontent")->add($data);
					$ne_contents[] = $subContentId;
				}
				$news_data['ne_contents'] = implode(",", $ne_contents);
				/* //判断是否有banner上传
				$upload_msg = "";
				$flag=false;
				foreach($_FILES as $f){
					if($f['name']!=''){
						$flag = true;break;
					}
				}
				//上传图片
				if($flag){
					$upload_info = $this->uploadImg();
					if(!$upload_info[0]){
						$upload_msg = $upload_info[1];				//上传失败
					}else{
						$news_data['ne_banner'] = $upload_info[1][0]['savename'];
					}
				} */
				if($news->add($news_data)){
					$this->watchdog("新增", "发布新闻《{$data['ne_title']}》");
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
			}else{
				$field = "ca_name,pro_id,pro_code";
				$join = "chuango_pro_category ON pro_ca_id=ca_id";
				$pro_lists = M("pro")->field($field)->join($join)->select();
				$this->assign("pro_list", $pro_lists);
				$this->display();
				exit;
			}
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	
	public function news_edit($action=""){
		if(!per_check("news_edit")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			$news = M("news");
			if($action=="edit"){
				$news_data = $news->create();
				$news_data['ne_relatepro'] = implode(",", $news_data['ne_relatepro']);
				$news_data['ne_time'] = strtotime($news_data['ne_time']);
				if(!isset($news_data['ne_publish'])){
					$news_data['ne_publish'] = "off";
				}
				if(!isset($news_data['ne_top'])){
					$news_data['ne_top'] = "off";
				}
				if(!empty($_POST['ne_content'])){
					$contents = $_POST['ne_content'];
					$oldContents = $news->where("ne_id={$news_data['ne_id']}")->getField("ne_contents");
					$count = count(explode(",",$oldContents));
					foreach($contents as $v){
						$data = array(
								"nec_content" => addslashes($v),
								"nec_order"=>$count
						);
						if($subContentId = M("newscontent")->add($data)){
							$ne_contents[] = $subContentId;
							$count++;
						}
					}
					if(!empty($ne_contents)){
						$news_data['ne_contents'] = $oldContents.",".implode(",", $ne_contents);
					}
				}
				/* //判断是否有banner上传
				$upload_msg = "";
				$flag=false;
				foreach($_FILES as $f){
					if($f['name']!=''){
						$flag = true;break;
					}
				}
				//上传图片
				if($flag){
					$upload_info = $this->uploadImg();
					if(!$upload_info[0]){
						$upload_msg = $upload_info[1];				//上传失败
					}else{
						$news_data['ne_banner'] = $upload_info[1][0]['savename'];
						$old_banner = $news->where("ne_id={$news_data['ne_id']}")->getField("ne_banner");
					}
				} */
				if($news->save($news_data)){
					$title = $news->where("ne_id={$news_data['ne_id']}")->getField("ne_title");
					$this->watchdog("编辑", "编辑新闻《{$title}》");
					// 删除旧图片
					/* if(isset($old_banner) && $old_banner!=""){
						$this->delOldImg($old_banner);
					} */
					$msg = response_msg("OPERATION_SUCCESS", "success");
				}else{
					$msg = response_msg("OPERATION_FAILED");
				}
				redirect(__URL__."/news_edit/ne_id/{$news_data['ne_id']}/msg/{$msg}");exit;
			}else{
				$ne_id = addslashes($_GET['ne_id']);
				$news_info = $news->where("ne_id={$ne_id}")->find();
				$ne_contents = explode(",", $news_info['ne_contents']);
				$map['nec_id'] = array("in", $ne_contents);
				$contents = M("newscontent")->where($map)->order("nec_order")->select();
				foreach($contents as $v){
					$v['nec_content'] = htmlspecialchars($v['nec_content']);
				}
				$this->assign("news", $news_info);
				$this->assign("contents", $contents);
				
				$field = "ca_name,pro_id,pro_code";
				$join = "chuango_pro_category ON pro_ca_id=ca_id";
				$pro_lists = M("pro")->field($field)->join($join)->select();
				$this->assign("pro_list", $pro_lists);
				$this->display();
				exit;
			}
		}
		
	}
	/**
	 * 修改新闻分页内容
	 */
	public function modifyNewsContent(){
		if(!per_check("news_edit")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$nec = M("newscontent");
		$data = $nec->create();
		$ne_id = addslashes($_POST['ne_id']);
		$news_info = M("news")->where("ne_id={$ne_id}")->find();
		$response = array(
			"code" => 0,
			"msg" => ""
		);
		if(!in_array($data['nec_id'], explode(",", $news_info['ne_contents']))){
			$response['code'] = 1;
			$response['msg'] = "参数错误!";
		}else{
			if($nec->save($data)){
				$this->watchdog("编辑", "编辑新闻《{$news_info['ne_title']}》的内容");
				$response['msg'] = "修改新闻分页内容成功";
			}else{
				$response['code'] = 1;
				$response['msg'] = "修改新闻分页内容失败";
			}
		}
		echo json_encode_nonull($response);
	}
	
	/**
	 * 删除新闻内容分页
	 */
	public function deleteNewsContent(){
		if(!per_check("news_edit")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$nec = M("newscontent");
		$data = $nec->create();
		$ne_id = addslashes($_POST['ne_id']);
		$news_info = M("news")->where("ne_id={$ne_id}")->find();
		$contents = explode(",", $news_info['ne_contents']);
		$response = array(
				"code" => 0,
				"msg" => ""
		);
		if(!in_array($data['nec_id'], $contents)){
			$response['code'] = 1;
			$response['msg'] = "参数错误!";
		}else{
			if($nec->where($data)->delete()){
				foreach($contents as $k=>$v){
					if($v==$data['nec_id']){
						unset($contents[$k]);
						break;
					}
				}
				M("news")->where("ne_id={$ne_id}")->save(array("ne_contents"=>implode(",", $contents)));
				$this->watchdog("删除", "删除新闻《{$news_info['ne_title']}》的分页内容");
				$response['msg'] = "删除新闻分页内容成功";
			}else{
				$response['code'] = 1;
				$response['msg'] = "删除新闻分页内容失败";
			}
		}
		echo json_encode_nonull($response);
	}
	/* 
	public function news_state(){
		
	}  */
	
	public function news_delete($chkt=""){
		if(!per_check("news_delete")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/index/msg/{$msg}");
			exit;
		}
		if(is_array($chkt)){
			$map = array("ne_id"=> array("in", $chkt));
		}else{
			$map = array("ne_id"=> $chkt);
		}
		$before_delete = M("news")->where($map)->select();
		if(M("news")->where($map)->delete()){
			foreach($before_delete as $k=>$v){
				if($v['ne_banner']){
					$this->delOldImg($v['ne_banner']);
				}
				$where = array("nec_id"=>array("in", $v['ne_contents']));
				M("newscontent")->where($where)->delete();
				$titles_arr[] = $v['ne_title'];
			}
			$titles = implode("》,《", $titles_arr);
			$this->watchdog("删除", "删除新闻《{$titles}》");
			$msg = response_msg("OPERATION_SUCCESS", "success");
			
		}else{
			$msg = response_msg("OPERATION_FAILED");
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	// 编辑焦点新闻的属性
	public function topic_news(){
		if(!per_check("news_topic")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		$clumn = addslashes($_POST['clumn']);
		$value = addslashes($_POST['value']);
		$response = array(
			"code"	=> 1,
			"msg"	=> ""
		);
		if($clumn == "nt_news"){
			$count = M("news")->where("ne_title='{$value}'")->count();
			if($count<1){
				$response['msg'] = "您所选择的的新闻不存在!!";
				exit(json_encode_nonull($response));
			}
		}else if($clumn=="nt_order"){
			if(!is_numeric($value)){
				$response['msg'] = "您所输入的排序编码不合法!";
				exit(json_encode_nonull($response));
			}
		}
		
		$data = array(
			"nt_id"	=> addslashes($_POST['id']),
			$clumn 	=> $value
		);
		if(M("newstopic")->save($data)){
			$response['code'] = 0;
			$this->watchdog("编辑", "修改焦点新闻的 {$clumn} 为 {$value}");
		}else{
			$response['msg'] = "SORRY:(  保存失败！";
		}
		echo json_encode_nonull($response);
	}
	
	public function topic_view($nt_id=""){
		if(!per_check("news_topic")){
			echo response_msg("Access Denied!", "error", true);
			exit;
		}
		if($nt_id){
			$html = '<form method="post" class="form-horizontal" enctype="multipart/form-data"><fieldset>
				<input type="hidden" name="nt_id" value="%id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>编辑<span class="">%page%</span>焦点新闻</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="u_name">新闻标题</label>
						<div class="controls">
							 <input type="text" id="nt_news" name="nt_news" class="typeahead" value="%news%" data-provide="typeahead" data-items="10" data-source=\'%titles%\' style="width:320px;" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="nt_order">顺序</label>
						<div class="controls">
						  	<input type="text" id="nt_order" name="nt_order" value="%order%" style="width:40px;">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="ba_src">焦点图片<br /> %size%</label>
						<div class="controls">
							<img src="%src%" style="height:40px;" /><br />
							<input type="file" class="input-file uniform_on" id="nt_img" name="nt_img" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="nt_desc">图片描述</label>
						<div class="controls">
						  	<input type="text" id="nt_desc" name="nt_desc" value="%desc%" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="topic_commit" data-act="%url%">修改</a>
				</div></fieldset></form>';
			
			$topic = M("newstopic")->join("chuango_news ON nt_news=ne_id")->where("nt_id={$nt_id}")->find();
			$lists = M("news")->order("ne_time DESC")->getField("ne_title", true);
			$titles = json_encode_nonull($lists);
			$size = $topic['nt_page'] == "index" ? "364px&times255px" : "243px&times174px" ;
			$page = array("news"=>"新闻页", "index"=>"首页");
			$tplArr = array("%id%", "%page%", "%news%", "%titles%", "%order%", "%size%", "%src%", "%desc%", "%url%");
			$replaceArr = array($topic['nt_id'], $page[$topic['nt_page']], $topic['ne_title'], $titles, $topic['nt_order'], $size, __ROOT__."/uploads/".$topic['nt_img'], $topic['nt_desc'], __URL__."/topic_save");
			echo str_replace($tplArr, $replaceArr, $html);
		}else{
			echo response_msg("参数错误！", "error", true);
		}
	}
	
	
	public function topic_save(){
		if(!per_check("news_topic")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/newstopic/msg/{$msg}");
			exit;
		}
		$errMsg = "";
		$data = M("newstopic")->create();
		$ne_id = M("news")->where("ne_title='{$data['nt_news']}'")->getField("ne_id");
		if($ne_id){
			$data['nt_news'] = $ne_id;
		}else{
			$errMsg .= "未找到该新闻!";
			unset($data['nt_news']);
		}
		//替换图片
		$flag = false;
		foreach($_FILES as $f){
			if($f['name']!=""){
				$flag = true;
				break;
			}
		}
		if($flag){
			$info = $this->uploadImg();
			if($info[0]){
				$data['nt_img'] = $info[1][0]['savename'];
				$old = M("newstopic")->where("nt_id='{$data['nt_id']}'")->getField("nt_img");
			}else{
				$errMsg .= $info[1];
			}
		}
		if(M("newstopic")->save($data)){
			$news = M("newstopic")->join(" chuango_news ON ne_id=nt_news")->where("nt_id='{$data['nt_id']}'")->getField("ne_title");
			$this->watchdog("编辑", "编辑修改焦点新闻《{$news}》");
			if(isset($old)){
				$this->delOldImg($old);
			}
			$msg = response_msg("OPERATION_SUCCESS", "success");
		}else{
			$msg = response_msg("OPERATION_FAILED".$errMsg);
		}
		redirect(__URL__."/newstopic/msg/{$msg}");
	}
	
	public function newsList(){
		$lists = M("news")->getField("ne_title", true);
		echo json_encode_nonull($lists);exit;
	}
	
	/* public function news_type(){
		
	}
	
	public function news_type_add(){
		
	} */
	
}