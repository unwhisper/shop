<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/25
 * Time: 14:00
 */

namespace app\admin\server;

use  app\common\model\Config;

class UploadifyServer
{
    public function getUploadSize()
    {
        $res = Config::where('name','file_size')->column('value');
        return $res;
    }
}