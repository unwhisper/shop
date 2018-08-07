<?php
/**
 * Created by PhpStorm.
 * User: jielei
 * Date: 2018.08.08
 * Time: 上午 12:23
 */

namespace app\admin\behavior;

use think\Controller;
use think\facade\Session;

class CheckLogin extends Controller
{
    public function run()
    {
        if (!Session::has('signin')){
            $this->error('请登录','admin/Index/login');
        }
    }
}