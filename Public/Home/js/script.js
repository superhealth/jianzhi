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
		if($("#agreement").prop("checked")==false){
			flag = false;
			bootbox.alert("请勾选用户协议！");
		}
		if(flag){
			$(this).parents("form")[0].submit();
		}
	});
	$(".inp").focus(function(){
		$(this).removeClass("error").removeClass("success");
		$(this).nextAll(".helpline").removeClass("error").removeClass("success");
	});
});