<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/12
 * Time: 9:49
 */

namespace app\admin\server;

use app\common\model\Admin;
use app\common\model\AdminRole;
use app\common\facade\SC;
use app\common\model\Order;
use app\common\model\Goods;
use app\common\model\Article;
use app\common\model\User;
use app\common\model\Comment;
use app\common\model\SystemMenu;
use think\facade\Config;
use app\common\model\Config as tpConfig;

class IndexServer
{
    //后台用户信息
    public function getAdminInfo()
    {
        $admin_id = SC::getLoginIdSession();
        if ($admin_id){
            $admin = Admin::with("AdminRole")->where('admin_id','=',$admin_id)->find();
            return $admin;
        }else{
            return 0;
        }
    }

    //待处理订单数
    public function getOrderCount()
    {
        $count = Order::where('order_status','=',0)->whereOr('pay_status','=',1)->whereOr('pay_code','cod')->count();
        if ($count) return $count;
            return 0;
    }

    //今天新增订单
    public function addOrder($today)
    {
        $count = Order::where("add_time",'>=',"$today")->count();
        if ($count) return $count;
            return 0;
    }

    //商品数
    public function productCount()
    {
        $count = Goods::where("is_on_sale",'=',1)->count();
        if ($count) return $count;
        return 0;
    }

    //文章数
    public function articleCount()
    {
        $count = Article::where("is_open",'=',0)->count();
        if ($count) return $count;
        return 0;
    }

    /**
     * 用户数量
     * @return float|int|string
     */
    public function userCount()
    {
        $count = User::count();
        if ($count) return $count;
        return 0;
    }

    /**
     * 今日登陆量
     * @param $today
     * @return float|int|string
     */
    public function todayLogin($today)
    {
        $count = User::where('last_login','>=',$today)->count();
        if ($count) return $count;
        return 0;
    }

    /**
     * 今日注册
     * @param $today
     * @return float|int|string
     */
    public function newUser($today)
    {
        $count = User::where('reg_time','>=',$today)->count();
        if ($count) return $count;
        return 0;
    }

    /**
     * 评论
     * @return float|int|string
     */
    public function commentCount()
    {
        $count = Comment::where('is_show','=',0)->count();
        if ($count) return $count;
        return 0;
    }

    /**
     * 获取后台菜单
     * @return mixed
     */
    public function getMenuArr(){
        $menuArr = Config::get('menu.');
        $act_list = session('admin')['role_list'];
        if($act_list != 'all' && !empty($act_list)){
            $right = SystemMenu::where("id", "in", $act_list)->cache(true)->column('right');
            $role_right = '';
            foreach ($right as $val){
                $role_right .= $val.',';
            }
            foreach($menuArr as $k=>$val){
                foreach ($val['child'] as $j=>$v){
                    foreach ($v['child'] as $s=>$son){
                        if(strpos($role_right,$son['op'].'@'.$son['act']) === false){
                            unset($menuArr[$k]['child'][$j]['child'][$s]);//过滤菜单
                        }
                    }
                }
            }
            foreach ($menuArr as $mk=>$mr){
                foreach ($mr['child'] as $nk=>$nrr){
                    if(empty($nrr['child'])){
                        unset($menuArr[$mk]['child'][$nk]);
                    }
                }
            }
        }
        return $menuArr;
    }

    public function getConfig()
    {
        $res = tpConfig::where('inc_type','shop_info')->select();
        $config = array();
        $prifix = 'shop_info_';
        foreach ($res as $k=>$val){
            $config[$prifix.$val['name']] = $val['value'];
        }
        return $config;
    }
}