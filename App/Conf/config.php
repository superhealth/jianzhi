<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * ThinkPHP惯例配置文件
 * 该文件请不要修改，如果要覆盖惯例配置的值，可在项目配置文件中设定和惯例不符的配置项
 * 配置名称大小写任意，系统会统一转换成小写
 * 所有配置参数都可以在生效前动态改变
 * @category Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id: convention.php 3088 2012-07-29 09:12:19Z luofei614@gmail.com $
 */
defined('THINK_PATH') or exit();
return  array(
		/* 项目设定 */
		'APP_STATUS'            => 'debug',  // 应用调试模式状态 调试模式开启后有效 默认为debug 可扩展 并自动加载对应的配置文件
		'APP_FILE_CASE'         => false,   // 是否检查文件的大小写 对Windows平台有效
		'APP_GROUP_LIST'        => 'Home,Carl',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
		/* Cookie设置 */
		'COOKIE_EXPIRE'         => 24*7*3600,    // Coodie有效期
		//'COOKIE_DOMAIN'         => '',      // Cookie有效域名
		//'COOKIE_PATH'           => '/',     // Cookie路径
		//'COOKIE_PREFIX'         => '',      // Cookie前缀 避免冲突
		/* 默认设定 */
		//'DEFAULT_APP'           => '@',     // 默认项目名称，@表示当前项目
		//'DEFAULT_LANG'          => 'zh-cn', // 默认语言
		//'DEFAULT_THEME'         => '',	// 默认模板主题名称
		'DEFAULT_GROUP'         => 'Home',  // 默认分组
		'DEFAULT_TIMEZONE'      => 'Asia/Chongqing',	// 默认时区
		//'DEFAULT_AJAX_RETURN'   => 'JSON',  // 默认AJAX 数据返回格式,可选JSON XML ...
		//'DEFAULT_JSONP_HANDLER' => 'jsonpReturn', // 默认JSONP格式返回的处理方法
		'DEFAULT_FILTER'        => 'htmlspecialchars', // 默认参数过滤方法 用于 $this->_get('变量名');$this->_post('变量名')...
		/* 数据库设置 */
		'DB_TYPE'               => 'mysql',     // 数据库类型
		'DB_HOST'               => 'localhost', // 服务器地址
		'DB_NAME'               => 'zhaotou',          // 数据库名
		'DB_USER'               => 'root',      // 用户名
		'DB_PWD'                => '',          // 密码
		'DB_PORT'               => '3306',        // 端口
		'DB_PREFIX'             => 'zt_',    // 数据库表前缀
		//'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
		
		/* 错误设置 */
		//'ERROR_MESSAGE'         => '页面错误！请稍后再试～',//错误显示信息,非调试模式有效
		//'ERROR_PAGE'            => '',	// 错误定向页面
		'SHOW_ERROR_MSG'        => true,    // 显示错误信息
		'TRACE_EXCEPTION'       => true,   // TRACE错误信息是否抛异常 针对trace方法
		'SHOW_PAGE_TRACE'		=>true,
		
		/* 模板引擎设置 */
		//'TMPL_CONTENT_TYPE'     => 'text/html', // 默认模板输出类型
		'TMPL_ACTION_ERROR'     => APP_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
		'TMPL_ACTION_SUCCESS'   => APP_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
		'TMPL_EXCEPTION_FILE'   => THINK_PATH.'Tpl/think_exception.tpl',// 异常页面的模板文件
		//'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
		//'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
		'TMPL_FILE_DEPR'        =>  '/', //模板文件MODULE_NAME与ACTION_NAME之间的分割符
		
		/* URL设置 */
		//'URL_CASE_INSENSITIVE'  => false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
		'URL_MODEL'             => 2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
		// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
		//'URL_PATHINFO_DEPR'     => '/',	// PATHINFO模式下，各参数之间的分割符号
		//'URL_PATHINFO_FETCH'    =>   'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
		'URL_HTML_SUFFIX'       => '.html',  // URL伪静态后缀设置
		//'URL_PARAMS_BIND'       =>  true, // URL变量绑定到Action方法参数
		'URL_404_REDIRECT'      =>  '', //404 跳转页面 部署模式有效
		
		/* EMAIL设置 */
		'THINK_EMAIL' => array(
				'SMTP_HOST'   => 'smtp.qq.com', //SMTP服务器
				'SMTP_PORT'   => '25', //SMTP服务器端口
				'SMTP_USER'   => '609164964@qq.com', //SMTP服务器用户名
				'SMTP_PASS'   => 'dapianzi', //SMTP服务器密码
				'FROM_EMAIL'  => '609164964@qq.com', //发件人EMAIL
				'FROM_NAME'   => 'Carl', //发件人名称
				'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
				'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
		),
		'ALIPAY' => array(
			'partner'			=> '',
			'key'				=> '',
			'sign_type'		=> 'MD5',
			'input_charset'=> 'utf-8',
			'cacert'    		=> getcwd().'\\cacert.pem',
			'transport'    	=> 'http',
			'seller_id' 		=> '',
			'seller_email' 	=> '',
			'seller_account_name' => '',
			'defaultbank' 	=> ''
		)
);