<?php
namespace app\admin\controller;

use app\common\controller\RedisServer;
use think\Controller;
use think\captcha\Captcha;
use app\admin\server\IndexServer;
use think\facade\Request;
use think\facade\Session;

class Index extends Controller
{
    protected $admin_id;

    protected $server;

    public function initialize()
    {
        parent::initialize();
        $this->admin_id = Session::get('admin.login_id');
        $this->server = new IndexServer();
    }

    public function index()
    {
        return $this->fetch();
    }

    public function updateLogo(Request $request)
    {
        $admin_id = $this->admin_id;
        $img = $request::post('imgData');
        $result = $this->server->updateLogo($admin_id,$img);
        return json($result);
    }

    public function test(Request $request)
    {
        if ($request::isPost()){
            $info = $request::post();
            $info['admin_id'] = $this->admin_id;
            return json($this->server->test($info));
        }
        return $this->fetch();
    }

    public function change(Request $request)
    {
        if ($request::isPost()){
            $article = $request::post();
            return json($this->server->updateArticle(10,$article));
        }else{
            $info = $this->server->getarticle(10);
            $this->assign("article",$info);
            return $this->fetch();
        }
    }

    public function showList()
    {
        $id = $this->admin_id;
        $list = $this->server->getList($id);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function showArticle(Request $request)
    {
        $id = $request::route('id');
        $info = $this->server->getarticle($id);
        $this->assign("article",$info);
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
                return json($this->server->login($username,$password,$rember));
            }else{
                return json(ajax_return(0,'验证码错误'));
            }
        }
        return $this->fetch();
    }

    public function logout()
    {
        $this->server->logout();
        $this->success('退出成功',"admin/Index/login");
    }

    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }
}
