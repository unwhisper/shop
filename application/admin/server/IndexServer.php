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

    public function userCount()
    {
        $count = User::count();
        if ($count) return $count;
        return 0;
    }

    public function todayLogin($today)
    {
        $count = User::where('last_login','>=',$today)->count();
        if ($count) return $count;
        return 0;
    }

    public function newUser($today)
    {
        $count = User::where('reg_time','>=',$today)->count();
        if ($count) return $count;
        return 0;
    }
    public function commentCount()
    {
        $count = Comment::where('is_show','=',0)->count();
        if ($count) return $count;
        return 0;
    }
}