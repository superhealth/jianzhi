<?php
/**
 * 支付宝接口模块
 * @author dapianzi
 *
 */
class AlipayAction extends EmptyAction{
	private $alipay_config; // 支付宝配置
	/**
	 * 初始化
	 */
	public function __construct(){
		EmptyAction::__construct();
		$this->alipay_config['partner']		= '';
		//安全检验码，以数字和字母组成的32位字符
		$this->alipay_config['key']			= '';
		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
		//签名方式 不需修改
		$this->alipay_config['sign_type']    = strtoupper('MD5');
		//字符编码格式 目前支持 gbk 或 utf-8
		$this->alipay_config['input_charset']= strtolower('utf-8');
		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$this->alipay_config['cacert']    = getcwd().'\\cacert.pem';	
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$this->alipay_config['transport']    = 'http';
		
		//卖家账号
		$this->alipay_config['seller_id'] = '';
		$this->alipay_config['seller_email'] = '';
		$this->alipay_config['seller_account_name'] = '';
		$this->alipay_config['defaultbank'] = '';
		
	}
	
	/**
	 * 测试
	 */
	public function testImplementation(){
		$this->display();
	}
	
	/**
	 * 支付年费
	 */
	public function duefeePay($duefee){
		import('@.ORG.alipay_submit');			
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url = "http://test.jianzhi.com/Alipay/duefeeNotifyUrl";
		//$return_url = "http://test.myorder.com.cn/Alipay/duefeeNotifyUrl";
		//$return_url = "http://www.myorder.com.cn/Alipay/duefeeNotifyUrl";
		//需http://格式的完整路径，不能加?id=123这类自定义参数		
		//页面跳转同步通知页面路径
		$return_url = "http://test.jianzhi.com/Alipay/duefeeReturnUrl";
		//$return_url = "http://test.myorder.com.cn/Alipay/duefeeReturnUrl";
		//$return_url = "http://www.myorder.com.cn/Alipay/duefeeReturnUrl";
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/		
		//卖家支付宝帐户
		$seller_email = $this->alipay_config['seller_email'];
		//必填		
		//商户订单号
		$out_trade_no = $duefee['out_trade_no'];
		//商户网站订单系统中唯一订单号，必填		
		//订单名称
		$subject = '年费续费单';
		//必填		
		//付款金额
		$total_fee = $duefee['total_fee'];
		//必填		
		//订单描述		
		$body = $duefee['body'];
		//默认支付方式
		$paymethod = "bankPay";
		//必填
		//默认网银
		$defaultbank = $this->alipay_config['defaultbank'];
		//必填，银行简码请参考接口技术文档		
		//商品展示地址
		$show_url = $duefee['show_url'];	
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数		
		//客户端的IP地址
		$exter_invoke_ip = "";
		//非局域网的外网IP地址，如：221.0.0.1				
		/************************************************************/		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> '年费续费单',
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"paymethod"	=> '',
				"defaultbank"	=> $this->alipay_config['defaultbank'],
				"show_url"	=> $duefee['show_url'],
				"anti_phishing_key"	=> $duefee['anti_phishing_key'],
				"exter_invoke_ip"	=> $duefee['exter_invoke_ip'],
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);		
		//建立请求
		//$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	
	
	/**
	 * 年费同步通知
	 */
	public function duefeeReturnUrl(){
		import("@.alipay_notify");
		$alipayNotify = new AlipayNotify($this->alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码		
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表		
			//商户订单号		
			$out_trade_no = $_GET['out_trade_no'];		
			//支付宝交易号		
			$trade_no = $_GET['trade_no'];		
			//交易状态
			$trade_status = $_GET['trade_status'];	
			
			// D('Duefee')->duefeeStatus($out_trade_no, $trade_status);
			
			if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
			}
			else {
				echo "trade_status=".$_GET['trade_status'];
			}		
			echo "验证成功<br />";
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			echo "验证失败";
		}
	}
	
	/**
	 * 保证金异步通知
	 */
	public function duefeeNotifyUrl(){
		import("@.alipay_notify");
		$alipayNotify = new AlipayNotify($this->alipay_config);
		// 验证返回结果
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			//请在这里加上商户的业务逻辑程序代				
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——		
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表		
			//商户订单号		
			$out_trade_no = $_POST['out_trade_no'];	
			//支付宝交易号		
			$trade_no = $_POST['trade_no'];		
			//交易状态
			$trade_status = $_POST['trade_status'];
			if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序	
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。		
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序		
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。		
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——		
			echo "success";		//请不要修改或删除
		}
		else {
			//验证失败
			echo "fail";
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	

	/**
	 * 支付年费
	 */
	public function depositPay($deposit=""){
		import('@.ORG.alipay_submit');
		/**************************请求参数**************************/
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url = "http://test.jianzhi.com/alipay/depositNotifyUrl";
		//$return_url = "http://test.myorder.com.cn/Alipay/depositNotifyUrl";
		//$return_url = "http://www.myorder.com.cn/Alipay/depositNotifyUrl";
		//需http://格式的完整路径，不能加?id=123这类自定义参数		
		//页面跳转同步通知页面路径
		$return_url = "http://test.jianzhi.com/Alipay/depositReturnUrl";
		//$return_url = "http://test.myorder.com.cn/Alipay/depositReturnUrl";
		//$return_url = "http://www.myorder.com.cn/Alipay/depositReturnUrl";
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
		//卖家支付宝帐户
		$seller_email = $this->alipay_config['seller_email'];
		//必填
		//商户订单号
		$out_trade_no = $_POST['WIDout_trade_no'];
		//商户网站订单系统中唯一订单号，必填
		//订单名称
		$subject = $_POST['WIDsubject'];
		//必填
		//付款金额
		$total_fee = $_POST['WIDtotal_fee'];
		//必填
		//订单描述
		$body = $_POST['WIDbody'];
		//默认支付方式
		$paymethod = "bankPay";
		//必填
		//默认网银
		$defaultbank = $_POST['WIDdefaultbank'];
		//必填，银行简码请参考接口技术文档
		//商品展示地址
		$show_url = $_POST['WIDshow_url'];
		//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数
		//客户端的IP地址
		$exter_invoke_ip = "";
		//非局域网的外网IP地址，如：221.0.0.1
		/************************************************************/
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($this->alipay_config['partner']),
				"payment_type"	=> '1',
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $this->alipay_config['seller_email'],
				"out_trade_no"	=> $out_trade_no, //$deposit['out_trade_no'],
				"subject"	=> $subject,  //$deposit['subject'],
				"total_fee"	=> $total_fee,	//$deposit['total_fee'],
				"body"	=> $body,	//$deposit['body'],
				"paymethod"	=> 'bankPay',
				"defaultbank"	=> '',
				"show_url"	=> $show_url,	//$deposit['show_url'],
				"anti_phishing_key"	=> '',
				"exter_invoke_ip"	=> '',
				"_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->alipay_config);
		//$html_text = $alipaySubmit->buildRequestHttp($parameter);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	
	/**
	 * 保证金同步页面
	 */
	public function depositReturnUrl(){
		import("@.alipay_notify");
		$alipayNotify = new AlipayNotify($this->alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			//商户订单号
			$out_trade_no = $_GET['out_trade_no'];
			//支付宝交易号
			$trade_no = $_GET['trade_no'];
			//交易状态
			$trade_status = $_GET['trade_status'];
			if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
			}
			else {
				echo "trade_status=".$_GET['trade_status'];
			}
			echo "验证成功<br />";
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			echo "验证失败";
		}
	}
	
	/**
	 * 保证金异步通知
	 */
	public function depositNotifyUrl(){
		import("@.alipay_notify");
		$alipayNotify = new AlipayNotify($this->alipay_config);
		// 验证返回结果
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			//请在这里加上商户的业务逻辑程序代
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];
			if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			echo "success";		//请不要修改或删除
		}
		else {
			//验证失败
			echo "fail";
			//调试用，写文本函数记录程序运行情况是否正常
			logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	
	public function depositBack(){
		require_once("lib/alipay_submit.class.php");		
		/**************************请求参数**************************/		
		//服务器异步通知页面路径
		$notify_url = "http://test.jianzhi.com/Alipay/depositBackNotify";
		//$notify_url = "http://test.myorder.com.cn/Alipay/depositBackNotify";
		//$notify_url = "http://www.myorder.com.cn/Alipay/depositBackNotify";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数		
		//卖家支付宝帐户
		$seller_email = $_POST['WIDseller_email'];
		//必填	
		//退款当天日期
		$refund_date = $_POST['WIDrefund_date'];
		//必填，格式：年[4位]-月[2位]-日[2位] 小时[2位 24小时制]:分[2位]:秒[2位]，如：2007-10-01 13:13:13		
		//批次号
		$batch_no = $_POST['WIDbatch_no'];
		//必填，格式：当天日期[8位]+序列号[3至24位]，如：201008010000001		
		//退款笔数
		$batch_num = $_POST['WIDbatch_num'];
		//必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）		
		//退款详细数据
		$detail_data = $_POST['WIDdetail_data'];
		//必填，具体格式请参见接口技术文档				
		/************************************************************/		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "refund_fastpay_by_platform_pwd",
				"partner" => trim($this->alipay_config['partner']),
				"notify_url"	=> $notify_url,
				"seller_email"	=> $seller_email,
				"refund_date"	=> $refund_date,
				"batch_no"	=> $batch_no,
				"batch_num"	=> $batch_num,
				"detail_data"	=> $detail_data,
				"_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
		);		
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}

}