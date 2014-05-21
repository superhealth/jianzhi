<?php
//项目入口

//定义项目名称
define('APP_NAME','App');
//定义项目路径
define('APP_PATH', './App/');  //在App目录下生成所有项目文件
//定义ThinkPHP框架路径
define('THINK_PATH','./ThinkPHP/');

//启动调试模式
define('APP_DEBUG', true);
//加载框架入口文件
require("./ThinkPHP/ThinkPHP.php");
?>