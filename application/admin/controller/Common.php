<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Cache;

class Common extends Controller
{
    public function initialize()
    {
        $request = $this->requestLimit();
        if ($request !== true){
            echo '访问过于频繁,请稍后尝试~~~';
            exit;
        }
    }

    public function requestLimit()
    {
        $key = get_real_ip();

        $check = Cache::store('redis')->has($key);
        if ($check){
            $count = Cache::store('redis')->get($key);
            if ($count >= 100){
                return false;
            }else{
                Cache::store('redis')->inc($key);
                return true;
            }
        }else{
            Cache::store('redis')->set($key,1,60);
            return true;
        }
    }
}