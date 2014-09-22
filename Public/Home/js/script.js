// JavaScript Document
$(function(){
	// 注册时选择个人或者公司
	if($("#company").prop("checked")==true){
		$(".input_company").show();
	}
	// 选择公司
	$("#company").click(function(e){
		if($(this).prop("checked")==false){
			e.preventDefault();
		}else{
			$(".input_company").show();
			$("#person").prop("checked", false);
		}
	});
	//  选择个人
	$("#person").click(function(e){
		if($(this).prop("checked")==false){
			e.preventDefault();
		}else{
			$(".input_company").hide();
			$("#company").prop("checked", false);
		}
	});
	// 校对密码
	$("#repass").blur(function(){
		if($(this).val()!=$("#pass").val()){
			$(this).addClass("error");
			$(this).next().addClass("error").html("密码不一致！");
		}else{
			$(this).addClass("success");
			$(this).next().addClass("success").html("一致！");
		}
	});
	// 检查用户名是否重复
	$("#reg_user").blur(function(){
		var user = $(this);
		if($(this).val()==""){
			user.addClass("error");
			user.next().addClass("error").html("用户名不能为空！");
			return;
		}
		$.post("/Member/checkUser", {'name':$(this).val()}, function(msg){
			if(msg=="fail"){
				user.addClass("error");
				user.next().addClass("error").html("用户名已存在！");
			}else if(msg == "ok"){
				user.addClass("success");
				user.next().addClass("success").html("用户名可用！");
			}else{
				bootbox.alert("系统错误："+msg);
			}
		}, 'text');
	});
	// 检查公司名字是否重复
	$("#com_name").blur(function(){
		var com_inp = $(this);
		if($(this).val()==""){
			com_inp.addClass("error");
			com_inp.nextAll(".helpline").addClass("error").html("公司不能为空！");
			return;
		}
		$.post("/Member/checkCompany", {'name':$(this).val()}, function(msg){
			if(msg=="fail"){
				com_inp.addClass("error");
				com_inp.nextAll(".helpline").addClass("error").html("公司名已存在！");
			}else if(msg == "ok"){
				com_inp.addClass("success");
				com_inp.nextAll(".helpline").addClass("success").html("可以使用！");
			}else{
				bootbox.alert("系统错误："+msg);
			}
		}, 'text');
	});
	// 注册
	$(".reg_btn").click(function(){
		var flag = true;
		var mailExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if($("#reg_user").val()==""){
			flag = false;
			$("#reg_user").addClass("error");
			$("#reg_user").next().addClass("error").html("用户名不能为空！");
		}
		if($("#pass").val()==""){
			flag = false;
			$("#pass").addClass("error");
			$("#pass").next().addClass("error").html("密码不能为空！");
		}
		if($("#repass").val()!=$("#pass").val()){
			flag = false;
			$("#repass").addClass("error");
			$("#repass").next().addClass("error").html("密码不一致！");
		}
		if($("#email").val()==""){
			flag = false;
			$("#email").addClass("error");
			$("#email").next().addClass("error").html("邮箱不能为空！");
		}
		if(!mailExp.test($("#email").val())){
			flag = false;
			$("#email").addClass("error");
			$("#email").next().addClass("error").html("邮箱格式错误！");
		}
		if($("#company").prop("checked") && $("#com_name").val()==""){
			flag = false;
			$("#com_name").addClass("error");
			$("#com_name").nextAll(".helpline").addClass("error").html("公司名不能为空！");
		}
		if($("#reg_user").hasClass("error")||$("com_name").hasClass("error")){
			flag = false;
		}
		if(flag){
			if($("#agreement").prop("checked")==false){
				bootbox.alert("请勾选用户协议！");
				return;
			}
			$(this).parents("form").attr("action", $(this).data("act")).submit();
		}
	});
	// 清除错误提示
	$(".inp").focus(function(){
		$(this).removeClass("error").removeClass("success");
		$(this).nextAll(".helpline").removeClass("error").removeClass("success");
	});
	// 登录
	$("#login_btn").click(function(){
		if($("#log_user").val()==''){
			$("#com_name").addClass("error");
			$("#com_name").nextAll(".helpline").addClass("error").html("请输入用户名！");
		}else if($("#log_pass").val()==""){
			$("#com_name").addClass("error");
			$("#com_name").nextAll(".helpline").addClass("error").html("请输入登录密码！");
		}else{
			$(this).parents('form').attr("action", $(this).data("act")).submit();
		}
	});
	
	/* 个人实名验证 */
	$("#verify_p").click(function(){
		var flag = true;
		var cellExp = /^1[3-8]\d{9}$/;
		var idExp = /^(\d{15}|\d{17}\w)$/;
		var attExp = /(\.jpg|\.gif|\.png|\.bmp|\.jpeg)$/i;
		if($("#mp_name").val()==""){
			flag = false;
			$("#mp_name").addClass("error");
			$("#mp_name").next().addClass("error").html("请填写真实姓名！");
		}
		if(!cellExp.test($("#mp_tel").val())){
			flag = false;
			$("#mp_tel").addClass("error");
			$("#mp_tel").next().addClass("error").html("请填写正确手机号！");
		}
		if(!idExp.test($("#mp_identily").val())){
			flag = false;
			$("#mp_identily").addClass("error");
			$("#mp_identily").next().addClass("error").html("请填写正确身份证号码！");
		}
		if(!attExp.test($("#mp_idscan").val())){
			flag = false;
			$("#mp_idscan").parent().next().addClass("error").html("上传格式:JPG, GIF, PNG, BMP, JPEG!");
		}
		if(flag){
			$(this).parents("form").attr("action", $(this).data("act")).submit();
		}
	});
	// 公司实名认证
	$("#verify_c").click(function(){
		var flag = true;
		var cellExp = /((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/;
		var attExp = /(\.jpg|\.gif|\.png|\.bmp|\.jpeg)$/i;
		if($("#mc_company").val()==""){
			flag = false;
			$("#mc_company").addClass("error");
			$("#mc_company").next().addClass("error").html("请填写企业全称！");
		}
		if(!cellExp.test($("#mc_tel").val())){
			flag = false;
			$("#mc_tel").addClass("error");
			$("#mc_tel").next().addClass("error").html("请填写正确电话号码！");
		}
		if(flag){
			$(this).parents("form").attr("action", $(this).data("act")).submit();
		}
	});
	// 模拟文件框
	$('.btn_file').click(function(){
		$(this).children('.inp-file')[0].click();
	});
	$(".inp-file").change(function(){
		$(this).parent().next('.helpline').removeClass("error");
		$(this).parent().siblings('.inp-file-text').val($(this).val());
	});
	
	/* 找回密码 */
	$('#re_step_1').click(function(){
		if($("#re_user").val()==""){
			$("#re_user").addClass("error");
			$("#re_user").next().addClass("error").html("请输入用户名！");
		}else{
			var authcode = $('#code').val();
			if(authcode==''){
				$("#code").addClass("error");
				$("#code").nextAll('.helpline').addClass("error").html("请输入验证码！");
			}else{
				var btn = $(this);
				$.post('/Home/Retrieve/checkAuthcode', {'authcode':authcode}, function(res){
					if(res=='ok'){
						btn.parents("form").attr("action", btn.data("act")).submit();
					}else{
						$("#code").addClass("error");
						$("#code").nextAll('.helpline').addClass("error").html("验证码输入错误！");
					}
				}, 'text');
			}
		}
		
	});
	// 找回密码第二步 重新发送安全码
	$('#reCode').click(function(){
		$.post('/Home/Retrieve/reCode', {'user':$('#re_user').val()}, function(res){
			bootbox.alert(res);
		}, 'text');
	});
	// 找回密码第二步
	$('#re_step_2').click(function(){
		if($("#safeCode").val()==""){
			$("#safeCode").addClass("error");
			$("#safeCode").next().addClass("error").html("请输入安全码！");
		}else{
			var code = $('#safeCode').val();
			var btn = $(this);
			$.post('/Home/Retrieve/checkCode', {'code':code, 'user':$('#re_user').val()}, function(res){
				if(res=='success'){
					btn.parents("form").attr("action", btn.data("act")).submit();
				}else{
					$("#safeCode").addClass("error");
					$("#safeCode").nextAll('.helpline').addClass("error").html(res);
				}
			}, 'text');
		}
	});
	// 找回密码 第三步验证
	$('#re_step_3').click(function(){
		if($("#pass").val()==""){
			$("#pass").addClass("error");
			$("#pass").next().addClass("error").html("请输入新密码！");
		}else if($("#pass").val() != $("#repass").val()){
			$("#newpass").addClass("error");
			$("#newpass").next().addClass("error").html("请输入新密码！");
		}else{
			$(this).parents("form").attr("action", $(this).data("act")).submit();
		}
	});
	// 顶部搜索模拟下拉框
	$('.search_filter').click(function(){
		if($(this).hasClass('off'))
		{
			$(this).removeClass('off').addClass('on');
			var p = $(this);
			$(".filter_type li").click(function(){
				$("#filter_val").text($(this).text());
				$('#filter_inp').val($(this).data('id'));
				p.removeClass('off').addClass('on');
			});
		}
		else
		{
			$(this).removeClass('on').addClass('off');
		}
	});
	// 
	$(".mem_subtoggle").click(function(e)
	{
		e.preventDefault();
		if($(this).hasClass("on"))
		{
			$(this).removeClass("on");
			$(this).next(".mem_submenu").slideUp();
		}
		else
		{
			$(this).addClass("on");
			$(this).next(".mem_submenu").slideDown();
		}
	});
	
	$(".area").change(function(){
				var n = $(this).attr("id").substr(-1,1);
				var name = $(this).val(),
						formName = $(this).attr('name').replace('[]', '');
				findSubArea(name, parseInt(n)+1, formName);
			});
	//查询子区域
	function findSubArea(name, n, formName){
		var url = "/Area/getSubArea";
		var data = {"name":name};
		$.post(url, data, function(msg){
			var f = parseInt(n)-1;
			$("#"+formName+f+"~.area").remove();
			if(msg!=""){
				$("<select name='"+formName+"[]' id='"+formName+n+"' class='area'></select>").insertAfter($("#"+formName+f));
				$("#"+formName+n).append(msg);
				$("#"+formName+n).change(function(){
					var name = $(this).val();
					findSubArea(name, parseInt(n)+1, formName);
				});
			}
		},"text");
	}
		
	// 链接按钮
	$('.btn-link').click(function(){
		location.href = $(this).data('href');
	});
	// 链接按钮
	$('.btn-sub').click(function(){
		$(this).parents('form').attr('action', $(this).data('act')).submit();
	});
	// 搜索
	$('#head_search_btn').click(function(){
		$('#head_filter_inp').val();
	});
	//colorbox
	$('.colorbox').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		$.get(url, null, function(html){
			bootbox.alert(html);
		}, 'html');
	});
	
	// 刷新验证码	
	$('.authcode').click(function(){
		$(this).attr('src', '/Home/Retrieve/getAuthcode?'+new Date().getTime());
	});

	
	$('.datepicker').datepicker("option", {minDate: new Date()});
	//gallery colorbox
	$('a.thumb').colorbox({transition:"elastic", maxWidth:"95%", maxHeight:"95%"});
	
	//check all
	$('.checkAll').click(function(){
		$('input:checkbox').prop('checked', $(this).prop('checked'));
	});
});