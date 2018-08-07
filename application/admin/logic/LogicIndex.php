<?php
/**
 * Created by PhpStorm.
 * User: jielei
 * Date: 2018.08.07
 * Time: 下午 10:21
 */

namespace app\admin\logic;

use app\model\Admin;
use app\model\AdminRole;
use think\facade\Session;

//登录业务
class LogicIndex
{
    /**
     * 用户登录
     * @param $info 用户信息
     * @return Admin|array|null
     * @throws \think\exception\DbException
     */
    public function login($username,$password)
    {
        $password = password_hash($password,PASSWORD_DEFAULT);
        $admin = Admin::with('adminRole')->where('user_name','=',$username)->find();
        //echo $admin->password;exit;
        if (!$admin){
            return ajax_return(0,'账号错误');
        }
        if (!$admin->password == md5(hash('sha512',$password))){
        //if (!$admin->password == $password){
            return ajax_return(0,'密码错误');
        }
        if ($admin->adminRole->act_list == '0' || empty($admin->adminRole->act_list)){
            return ajax_return(0,'该账号没有权限');
        }
        Session::set('signin',true);
        return ajax_return(1,'登录成功');
    }
}