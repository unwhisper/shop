<?php
namespace app\admin\controller;

use app\common\controller\RedisServer;
use think\Controller;
use think\captcha\Captcha;
use app\admin\server\AdminServer;
use think\facade\Request;
use think\facade\Session;

class Admin extends Controller
{
    protected $admin_id;

    protected $server;

    public function initialize()
    {
        parent::initialize();
        $this->admin_id = Session::get('admin.login_id');
        $this->server = new AdminServer();
    }

    /**
     * 后台首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 上传头像
     * @param Request $request
     * @return \think\response\Json
     */
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

    /**
     * 后台用户登录
     * @param Request $request
     * @return mixed|\think\response\Json
     */
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

    /**
     * 用户登出
     */
    public function logout()
    {
        $this->server->logout();
        $this->success('退出成功',"admin/Admin/login");
    }

    /**
     * 验证码
     * @return \think\Response
     */
    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }

    public function ewe()
    {
        $server = RedisServer::getInstance(array('port'=>6379,'host'=>'127.0.0.1'),2);
        $server->set('name','leijie');
        $server->setex('class',60,'xixi');
        $server->setnx('name','dfjf');
        $server1 = RedisServer::getInstance(array('port'=>6379,'host'=>'127.0.0.1'),8);
        $server1->set('name','leijie');
        $server1->setex('class',60,'xixi');
        $server1->setnx('name','dfjf');
    }
}
