<?php
class ProductAction extends BaseAction{
	/**
	 * 产品首页
	 */
	public function index(){
		$category = M("pro_category");
		$map = array();
		$param = array();
		if($_REQUEST[''] == ""){
			$map[''] = $_REQUEST[''];
			
		}
		
		$join = " (SELECT count(*) pro_count,pro_ca_id FROM chuango_pro GROUP BY pro_ca_id) t ON ca_id=pro_ca_id";
		$field = "ca_id, ca_name, ca_desc, ca_order, ca_keywords, ca_template, IFNULL(pro_count, 0) pro_count";
		$order = "ca_order";
		$categorys = $category->field($field)->join($join)->where($map)->order($order)->select();
		$this->assign("categorys", $categorys);
		$this->display();
	}
	
	/**
	 * 查看产品
	 * @param string $pro_id
	 */
	public function pro_view($pro_id=""){
		$pro_info = M("pro")->where("pro_id={$pro_id}")->find();
		$this->assign("pro", $pro_info);
		$categorys = M("pro_category")->getField("ca_id, ca_name");
		$this->assign("categorys", $categorys);
		//相关产品
		$field = "ca_name,pro_id,pro_code";
		$join = "chuango_pro_category ON pro_ca_id=ca_id";
		$pro_lists = M("pro")->field($field)->join($join)->select();
		$this->assign("pro_list", $pro_lists);
		$this->display();
	}
	
	/**
	 * 编辑产品
	 */
	public function pro_edit(){
		$pro = M("pro");
		$data = $pro->create();
		if(!per_check("pro_edit")){
			$msg = response_msg("ACCESS_DENIED");
		}else{
			
			// 相关产品
			$data['pro_relatepro'] = implode(",", $data['pro_relatepro']);
			//
			if(!is_numeric($data['pro_order'])){
				unset($data['pro_order']);
			}
			//判断是否有图片上传
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
					$data['pro_thumb'] = $upload_info[1][0]['savename'];
					$oldThumb = $pro->where("pro_id={$data['pro_id']}")->getField("pro_thumb");
				}
			}
			//保存
			if($pro->save($data)){
				$this->watchdog("编辑", "修改产品‘{$data['pro_name']}’的信息");
				if(isset($oldThumb)){
					$this->delOldImg($oldThumb);
				}
				$msg = response_msg("OPERATION_SUCCESS","success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}
		redirect(__URL__."/pro_view/pro_id/{$data['pro_id']}/msg/{$msg}");
	}
	
	/**
	 * 添加产品
	 */
	public function pro_add($action=""){
		if(!per_check("pro_add")){
			$msg = response_msg("ACCESS DENIED!");
			redirect(__URL__."/pro_lists/msg/{$msg}");exit;
		}
		if($action=="add"){
			$pro = M("pro");
			$data = $pro->create();
			// 相关产品
			$data['pro_relatepro'] = implode(",", $data['pro_relatepro']);
			if(empty($data['pro_order']) || !is_numeric($data['pro_order'])){
 				$lastId = $pro->order("pro_id DESC")->limit(1)->getField("pro_id");
				$data['pro_order'] = $lastId+1;
			}
			$info = $this->uploadImg();
			if(!$info[0]){
				$msg = response_msg("UPLOAD_FAILED");
				redirect(__URL__."/pro_add/msg/{$msg}");exit;
			}else{
				$data['pro_thumb'] = $info[1][0]['savename'];
			}
			if($pro->add($data)){
				$this->watchdog("新增", "添加产品《{$data['pro_name']}》成功!");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
			redirect(__URL__."/pro_lists/msg/{$msg}");exit;
		}else{
			if(isset($_REQUEST['ca_id'])){
				$this->assign("ca", $_REQUEST['ca_id']);
			}
			$categorys = M("pro_category")->getField("ca_id, ca_name");
			$this->assign("categorys", $categorys);
			//已有产品
			$field = "ca_name,pro_id,pro_code";
			$join = "chuango_pro_category ON pro_ca_id=ca_id";
			$pro_lists = M("pro")->field($field)->join($join)->select();
			$this->assign("pro_list", $pro_lists);
			$this->display();
		}
	}
	
	/**
	 * 
	 */
	public function proCheck(){
		if(isset($_POST['name'])){
			$name = addslashes($_POST['name']);
			$count = M("pro")->where("pro_name='{$name}'")->count();
			if($count<1){
				echo "correct";
			}else{
				echo "wrong";
			}
		}elseif(isset($_POST['code'])){
			$code = addslashes($_POST['code']);
			$count = M("pro")->where("pro_code='{$code}'")->count();
			if($count<1){
				echo "correct";
			}else{
				echo "wrong";
			}
		}elseif(isset($_POST['template'])){
			$filedir = $_SERVER['DOCUMENT_ROOT'].__ROOT__.TMPL_PATH."/Home/".$_POST['template'];
			if(!file_exists($filedir)){
				echo $filedir;
				echo "wrong";
			}else{
				echo "correct";
			}
		}else{
			echo "wrong";
		}
	}
	
	/**
	 * 删除产品
	 * @param string $chkt
	 */
	public function product_delete($chkt=""){
		if(!per_check("pro_delete")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/pro_lists/msg/{$msg}");exit;
		}
		if(is_array($chkt)){
			$map['pro_id'] = array("in", $chkt);
		}else{
			$map['pro_id'] = $chkt;
		}
		$pros = M("pro")->where($map)->select();
		if(count($pros)==0){
			$msg = response_msg("INVALID_ARGUMENT");
			redirect(__URL__."/pro_lists/msg/{$msg}");
		}
		if(M("pro")->where($map)->delete()){
			foreach($pros as $v){
				$names[] = $v['pro_name'];
				$this->delOldImg($v['pro_thumb']);
			}
			$this->watchdog("删除", "成功删除产品：".implode(",", $names));
			$msg = response_msg("OPERATION_SUCCESS","success");
		}else{
			$msg = response_msg("OPERATION_FAILED");
		}
		redirect(__URL__."/pro_lists/msg/{$msg}");
	}
	
	/**
	 * 产品列表
	 */
	public function pro_lists(){
		$pro = M("pro");
		$map = array();
		$param = array();
		if(isset($_REQUEST['cate'])&&$_REQUEST['cate']!="all"){
			$map['pro_ca_id'] = $_REQUEST['cate'];
			$param['cate'] = $_REQUEST['cate'];
		}
		if(isset($_REQUEST['words'])){
			$word = addslashes($_REQUEST['words']);
			if(strlen($word)>=3){
				$where['pro_code']  = array('like', "%{$word}%");
				$where['pro_name']  = array('like',"%{$word}%");
				$where['pro_title']  = array('like', "%{$word}%");
				$where['_logic'] = 'or';
				$map['_complex'] = $where;
				$param['words'] = $_REQUEST['words'];
			}
		}
		$this->assign("param", $param);
		$total = $pro->where($map)->count();
		import("ORG.Util.Page");
		$page = new Page($total, 12, $param);
		$pager = $page->shown();
		$this->assign("pager", $pager);
		$limit = $page->firstRow.",".$page->listRows;
		$order = "pro_ca_id, pro_order";
		$join = "chuango_pro_category ON pro_ca_id=ca_id";
		$products = $pro->join($join)->where($map)->order($order)->limit($limit)->select();
		//换色
		if(!empty($param['words'])){
			foreach($products as &$v){
				foreach($v as &$val){
					$val = preg_replace("/(".$param['words'].")/i", "<span class='red'>\\1</span>", $val);
				}
			}
		}
		$this->assign("pruducts", $products);
		$cate = M("pro_category")->getField("ca_id,ca_code");
		$this->assign("cate", $cate);
		$this->display();
	}
	
	/**
	 * 添加产品分类
	 */
	public function category_add($action=""){
		if(!per_check("category_add")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/index/msg/{$msg}");exit;
		}
		if($action=="add"){
			$data = M("pro_category")->create();
			$data['ca_relatepro'] = implode(",", $data['ca_relatepro']);
			if(empty($data['ca_order']) || !is_numeric($data['ca_order'])){
				$lastId = M("pro_category")->order("ca_id DESC")->limit(1)->getField("ca_id");
				$data['ca_order'] = $lastId+1;
			}
			if(M("pro_category")->add($data)){
				$this->watchdog("新增", "添加产品分类 {$data['ca_name']}");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
			redirect(__URL__."/index/msg/{$msg}");
			exit;
		}else{
			$field = "ca_name,pro_id,pro_code";
			$join = "chuango_pro_category ON pro_ca_id=ca_id";
			$pro_lists = M("pro")->field($field)->join($join)->select();
			$this->assign("pro_list", $pro_lists);
			$this->display();
		}
	}
	
	
	/**
	 * 编辑产品分类
	 */
	public function category_edit($action=""){
		if(!per_check("category_edit")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/index/msg/{$msg}");exit;
		}
		if($action=="edit"){
			$data = M("pro_category")->create();
			$data['ca_relatepro'] = implode(",", $data['ca_relatepro']);
			if(M("pro_category")->save($data)){
				$this->watchdog("编辑", "编辑产品分类 《{$data['ca_name']}》的信息");
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
			redirect(__URL__."/category_edit/ca_id/{$data['ca_id']}/msg/{$msg}");exit;
		}else{
			$ca_id = addslashes($_GET['ca_id']);
			if(!empty($ca_id)){
				$ca_info = M("pro_category")->where("ca_id={$ca_id}")->find();
				$this->assign("ca_info", $ca_info);
				
				$field = "ca_name,pro_id,pro_code";
				$join = "chuango_pro_category ON pro_ca_id=ca_id";
				$pro_lists = M("pro")->field($field)->join($join)->select();
				$this->assign("pro_list", $pro_lists);
				$this->display();exit;
			}else{
				$msg = response_msg("INVALID_ARGUMENT");
				redirect(__URL__."/index/msg/{$msg}");
			}
			
		}
	}
	
	/**
	 * 删除分类
	 */
	public function category_delete($chkt=""){
		if(!per_check("category_delete")){
			$msg = response_msg("ACCESS_DENIED");
			redirect(__URL__."/index/msg/{$msg}");exit;
		}
		if($chkt){
			if(!is_array($chkt)){
				$chkt = array($chkt);
			}
			
			$pro_msg = "";
			foreach($chkt as $k=>$v){
				$pro_count = M("pro")->where("pro_ca_id={$v}")->count();
				if($pro_count>0){
					$ca_name = M("pro_category")->where("ca_id={$v}")->getField("ca_name");
					$pro_msg .= "`{$ca_name}`分类下有{$pro_count}件产品,无法删除;";
					unset($chkt[$k]);
				}
			}
			if(count($chkt) == 0){
				$msg = response_msg("INVALID_ARGUMENT");
				redirect(__URL__."/index/msg/{$msg}");exit;
			}
			$map['ca_id'] = array("in", $chkt);
			$ca_names = M("pro_category")->where($map)->getField("ca_name", true);
			if(M("pro_category")->where($map)->delete()){
				$this->watchdog("删除", "成功删除产品分类".implode(",", $ca_names));
				$msg = response_msg("OPERATION_SUCCESS", "success");
			}else{
				$msg = response_msg("OPERATION_FAILED");
			}
		}else{
			$msg = response_msg("INVALID_ARGUMENT");
		}
		redirect(__URL__."/index/msg/{$msg}");
	}
	
	public function relation(){
		$relations = M("pro_relation")->select();
		foreach($relations as &$v){
			$pro_map = array("pro_id"=>array("in",explode(",", $v['re_relatepro'])));
			$v['re_count'] = count($pro_map["pro_id"][1]);
			$v['pros'] = M("pro")->where($pro_map)->limit(4)->getField("pro_name, pro_thumb", true);
		}
		$this->assign("relations", $relations);
		
		$this->display();
		
	}
	
	/* public function relation_add($page=""){
		$rela = M("pro_relation");
		if($page){
			$html = '';
		}else{
			$msg = response_msg("参数错误！", "error", ture);
			//已有页面
			$pages = $rela->group("re_page")->getField("re_page", true);
			if($pages){
				$pro_map['pro_name'] = array("not in", $pages);
			}else{
				$pro_map = array();
			}
			$pro_names = M("pro")->where($pro_map)->getField("pro_name", true);
			$html = ''; 
		}
	} */
	
	public function relation_info($re_id=""){
		if(!per_check("relate_edit")){
			echo response_msg("ACCESS DENIED!!", "error", true);
			exit;
		}
		if($re_id){
			$html1 = '<form method="post" class="form-horizontal" enctype="multipart/form-data" ><fieldset>
				<input type="hidden" name="re_id" value="%re_id%" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>%page%页面产品关联</h3>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<label class="control-label" for="re_page">页面描述</label>
						<div class="controls">
							<input type="text" id="re_pageinfo" name="re_pageinfo" value="%pageinfo%" />
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="re_relatepro">关联产品</label>
						<div class="controls">
							<select name="re_relatepro[]" id="re_relatepro" data-rel="chosen" multiple>';
			$html2 = 	'</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<a href="#" class="btn btn-primary" id="relate_commit" data-act="%url%">保存</a>
				</div></fieldset></form>';
			$re_info = M("pro_relation")->where("re_id={$re_id}")->find();
			//已有产品
			$field = "ca_name,pro_id,pro_code";
			$join = "chuango_pro_category ON pro_ca_id=ca_id";
			$pro_lists = M("pro")->field($field)->join($join)->select();
			$url = __URL__."/relation_edit";
			echo str_replace(array("%re_id%", "%page%", "%pageinfo%"), array($re_info['re_id'], $re_info['re_page'], $re_info['re_pageinfo']), $html1);
			pro_options($pro_lists, $re_info['re_relatepro']);
			echo str_replace(array("%url%"), array($url), $html2);
		}else{
			echo response_msg("参数错误！！", "error", true);
			exit;
		}
	}
	
	public function relation_edit($re_id=""){
		if(!per_check("relate_edit")){
			$msg = response_msg("ACCESS_DENIED", "error", true);
			redirect(__URL__."/relation/msg/{$msg}");
			exit;
		}
		$data = M("pro_relation")->create();
		$data['re_relatepro'] = implode(",", $data['re_relatepro']);
		if(M("pro_relation")->save($data)){
			$this->watchdog("编辑", "更改{$data['re_pageinfo']}的关联产品");
			$msg = response_msg("OPERATION_SUCCESS", "success");
		}else{
			$msg = response_msg("OPERATION_FAILED");
		}
		redirect(__URL__."/relation/msg/{$msg}");
	}
	
	/* public function relation_delete($re_id=""){
		
	} */
}