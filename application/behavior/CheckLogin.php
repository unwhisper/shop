<?php
namespace app\behavior;

use think\Controller;
use SC;
use think\facade\Request;
use think\facade\Config;

class CheckLogin extends Controller
{
    public function run(Request $request)
    {
        $ctl = strtolower($request::controller()).'/'.$request::action();
        $except = Config::get('except.admin');
        if (!SC::getLoginSession()){
            if (!in_array($ctl,$except)){
                $this->error('请登录','admin/Admin/login');
            }
        }else{
            //登陆成功
            if (in_array($ctl,$except)){
                $this->success('登陆成功','admin/Index/index');
            }
        }
    }
}