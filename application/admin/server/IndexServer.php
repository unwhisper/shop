<?php
namespace app\admin\server;

use app\model\Admin;
use app\model\AdminRole;
use app\model\Article;
use think\facade\Cookie;
use SC;

//登录业务
class IndexServer
{
    /**
     * 后台登录
     * @param $username 用户名
     * @param $password 密码
     * @return array 登录提示
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($username,$password,$rember='')
    {
        $admin = Admin::with('adminRole')->where('user_name','=',$username)->find();
        if (!$admin){
            return ajax_return(0,'账号错误');
        }
        if (!$admin->password == md5(hash('sha512',$password))){
            return ajax_return(0,'密码错误');
        }
        if ($admin->adminRole->act_list == '0' || empty($admin->adminRole->act_list)){
            return ajax_return(0,'该账号没有权限');
        }
        SC::setLoginIdSession($admin->admin_id);
        SC::setUserInfoSession($admin->user_name);
        SC::setUserRoleSession($admin->adminRole->role_name);
        $ip = get_real_ip();
        Admin::where('user_name',$username)->update(['last_login' => time(),'last_ip' => $ip]);
        if ($rember == 'on' && !Cookie::has('rember')){
            Cookie::set('username',$username,3600*24*30);
            Cookie::set('password',$password,3600*24*30);
            Cookie::set('rember','on',3600*24*30);
        }elseif($rember == ''){
            Cookie::clear('shop_');
        }
        return ajax_return(1,'登录成功');
    }

    //登出
    public function logout()
    {
        SC::delLoginSession();
    }

    public function test($info)
    {
        $res = Article::create($info);
        if ($res){
            return ajax_return(1,'添加成功');
        }else{
            return ajax_return(0,'添加失败');
        }
    }
}