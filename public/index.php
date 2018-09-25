<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

if (version_compare(PHP_VERSION,'5.6.0','<')){
    header("Content-type: text/html; charset=utf-8");
    die('PHP 版本必须大于5.6.0!');
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);//报告运行时错误

$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
define('SITE_URL',$http.'://'.$_SERVER['HTTP_HOST']); // 网站域名
defined('UPLOAD_PATH') or define('UPLOAD_PATH','static/upload/'); // 编辑器图片上传路径
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 定义时间
define('NOW_TIME',$_SERVER['REQUEST_TIME']);
// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();
