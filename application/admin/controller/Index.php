<?php
namespace app\admin\controller;

use think\Controller;
use think\captcha\Captcha;
use app\admin\logic\LogicIndex;
use think\facade\Request;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function login(Request $request)
    {
        if ($request::isPost()){
            $info = $request::post();
            $verify = $info['verify'];
            if ($this->checkCode($verify)){
                $username = $request::post('username');
                $password = $request::post('password');
                $logic = new LogicIndex();
                return json($logic->login($username,$password));
            }
        }
        return $this->fetch();
    }

    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }

    public function checkCode($code)
    {
        if (!captcha_check($code)){
            $this->error('验证码错误');
        }
        return true;
    }
}
