<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/8/16 0016
 * Time: 16:31
 */

namespace app\common\controller;

use upload\EditorMdUploader;
use think\Controller;

class Upload
{
    public function upload()
    {
        $path     = __DIR__ . DIRECTORY_SEPARATOR;var_dump($path);
        $url      = dirname($_SERVER['PHP_SELF']) . '/';var_dump($url);
        $savePath = realpath($path . '../uploads/') . DIRECTORY_SEPARATOR;var_dump($savePath);
        $saveURL  = $url . '../uploads/';var_dump($saveURL);exit;
    }
}