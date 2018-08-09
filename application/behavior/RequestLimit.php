<?php
/**
 * Created by PhpStorm.
 * User: jielei
 * Date: 2018.08.09
 * Time: 下午 11:07
 */

namespace app\behavior;

use think\Controller;
use think\facade\Cache;

class RequestLimit extends Controller
{
    public function run()
    {
        $key = get_real_ip();

        $check = Cache::store('redis')->has($key);
        if ($check){
            $count = Cache::store('redis')->get($key);
            if ($count >= 100){
                echo '访问过于频繁,请稍后尝试~~~';
                exit;
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