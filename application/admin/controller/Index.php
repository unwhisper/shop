<?php
namespace app\admin\controller;

use think\Controller;
use think\captcha\Captcha;
use app\admin\server\IndexServer;
use think\facade\Request;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function test()
    {
        return $this->fetch();
    }

    public function login(Request $request)
    {
        if ($request::isPost()){
            $info = $request::post();
            $verify = $info['verify'];
            if (captcha_check($verify)){
                $username = $request::post('username');
                $password = $request::post('password');
                $rember = $request::post('rember');
                $server = new IndexServer();
                return json($server->login($username,$password,$rember));
            }else{
                return json(ajax_return(0,'验证码错误'));
            }
        }
        return $this->fetch();
    }

    public function logout()
    {
        $server = new IndexServer();
        $server->logout();
        $this->success('退出成功',"admin/Index/login");
    }

    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }
}
