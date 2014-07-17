// JavaScript Document
$(function(){
	// regform
	if($("#company").prop("checked")==true){
		$(".input_company").show();
	}
	$("#company").click(function(e){
		if($(this).prop("checked")==false){
			e.preventDefault();
		}else{
			$(".input_company").show();
			$("#person").prop("checked", false);
		}
	});
	$("#person").click(function(e){
		if($(this).prop("checked")==false){
			e.preventDefault();
		}else{
			$(".input_company").hide();
			$("#company").prop("checked", false);
		}
	});
	$("#repass").blur(function(){
		if($(this).val()!=$("#pass").val()){
			$(this).addClass("error");
			$(this).next().addClass("error").html("密码不一致！");
		}else{
			$(this).addClass("success");
			$(this).next().addClass("success").html("一致！");
		}
	});
	$("#user").blur(function(){
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
	$(".reg_btn").click(function(){
		var flag = true;
		var mailExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if($("#user").val()==""){
			flag = false;
			$("#user").addClass("error");
			$("#user").next().addClass("error").html("用户名不能为空！");
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
		if($("#user").hasClass("error")||$("com_name").hasClass("error")){
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
	$(".inp").focus(function(){
		$(this).removeClass("error").removeClass("success");
		$(this).nextAll(".helpline").removeClass("error").removeClass("success");
	});
	
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
		if($("#mp_addr").val()==""){
			flag = false;
			$("#mp_addr").addClass("error");
			$("#mp_addr").next().addClass("error").html("请填写详细通讯地址！");
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
	$("#verify_c").click(function(){
		var flag = true;
		var cellExp = /((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/;
		var attExp = /(\.jpg|\.gif|\.png|\.bmp|\.jpeg)$/i;
		if($("#mc_company").val()==""){
			flag = false;
			$("#mc_company").addClass("error");
			$("#mc_company").next().addClass("error").html("请填写企业全称！");
		}
		if($("#mc_addr").val()==""){
			flag = false;
			$("#mc_addr").addClass("error");
			$("#mc_addr").next().addClass("error").html("请填写企业注册地址！");
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
	$(".inp-file").change(function(){
		$(this).parent().next().removeClass("error");
		$(this).parent().prev().val($(this).val());
	});
	
	
	
	
	
	
	
	$('.datepicker').datepicker({ currentText: 'Now' ,dateFormat: "yy-mm-dd"});
	//gallery colorbox
	$('a.thumb').colorbox({transition:"elastic", maxWidth:"95%", maxHeight:"95%"});
	
});