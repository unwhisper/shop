<?php
namespace app\common\controller;

use think\facade\Session;

class SC{
    /**
     * 后台用户
     */
    const PRI_KEY = 'admin';
    /**
     * 用户登录的session key
     */
    CONST LOGIN_ID = 'login_id';
    /**
     * 权限信息
     *
     * @var string
     */
    CONST USER_ROLE = 'user_role';
    /**
     * 权限列表
     */
    CONST ROLE_LIST = 'role_list';
    /**
     * USER用户信息
     *
     * @var string
     */
    CONST USER_INFO = 'user_info';

    /**
     * 设置登录成功id的session
     *
     * @param array $USERInfo 用户的相关信息
     */
    public function setLoginIdSession($userInfo)
    {
        Session::set(self::PRI_KEY.'.'.self::LOGIN_ID, $userInfo);
    }

    /**
     * 返回登录成功id的session
     */
    public function getLoginIdSession()
    {
        return Session::get(self::PRI_KEY.'.'.self::LOGIN_ID);
    }

    /**
     * 把所有的用户保存到session中。
     *
     * @access public
     * @return true|false
     */
    public function setUserInfoSession($userInfo)
    {
        Session::set(self::PRI_KEY.'.'.self::USER_INFO, $userInfo);
    }

    /**
     * 返回保存在session中的所有用户信息
     *
     * @access public
     */
    public function getUserInfoSession()
    {
        return Session::get(self::PRI_KEY.'.'.self::USER_INFO);
    }

    /**
     * 把权限保存到session中。
     *
     * @access public
     * @return true|false
     */
    public function setUserRoleSession($userRole)
    {
        Session::set(self::PRI_KEY.'.'.self::USER_ROLE, $userRole);
    }

    /**
     * 返回保存在session中的权限信息
     *
     * @access public
     */
    public function getUserRoleSession()
    {
        return Session::get(self::PRI_KEY.'.'.self::USER_ROLE);
    }

    /**
     * @param $role_list 权限列表
     */
    public function setRoleList($role_list)
    {
        return Session::set(self::PRI_KEY.'.'.self::ROLE_LIST,$role_list);
    }

    public function getRoleList()
    {
        return Session::get(self::PRI_KEY.'.'.self::ROLE_LIST);
    }
    /**
     * 获取登陆session
     * @return mixed
     */
    public function getLoginSession()
    {
        return Session::get(self::PRI_KEY);
    }
    /**
     * 删除登录的session
     *
     * @return void
     */
    public function delLoginSession()
    {
        Session::clear(self::PRI_KEY);
    }
}