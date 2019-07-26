<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 创建header头
header("Content-type: text/html; charset=utf-8");

//die('<h3>系统维护中……</h3>');

// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 定义静态文件目录
define('__PUBLIC__',__DIR__.'/public/static/');
// 定义静态文件目录
define('__TEMPLATES__',__DIR__.'/templates/');
// 定义session文件目录
define('SESSION_PATH',__DIR__.'/runtime/session/');
// 定义系统版本
define('WEB_VERSION','v1.5.08');

// 开启数据调试模式时，锁定业务无法操作
define('DATA_DEBUG',false);

// 【更新资源文件请修改下面的版本号】
define('VERSION','v1.5.08_1');

set_time_limit(800);

ini_set('memory_limit','512M');

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
