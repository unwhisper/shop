<?php
namespace app\index\controller;

use think\Controller;
use app\common\controller\RedisServer;
use think\facade\Config;

class Index extends Controller
{
    private  $redis;
    private  $redis1;
    public function initialize()
    {
        $this->redis = RedisServer::getInstance(array('host' => '127.0.0.1', 'port' => 6379),array('timeout'=>100,'db_id'=>1));
        $this->redis1 = RedisServer::getInstance(array('host' => '127.0.0.1', 'port' => 6379),array('timeout'=>100,'db_id'=>0));
    }

    /*public function index()
    {
       /* dump($this->redis->hSet('user','name','leijie',30));
        dump($this->redis->setnx('name','leijie',10));
        dump($this->redis->keys('name'));
        dump($this->redis->ttl('user'));
        $this->redis->multi()->set('pass','1234556')->setex('verify',60,'aser')->exec();
        dump($this->redis->ping());
        dump($this->redis1->hSet('user','age',22,30));
        dump($this->redis1->hMset('admin',['age' => 22],30));
        return $this->fetch();
    }*/
    public function index(){

        // 如果是手机跳转到 手机模块
        if(is_mobile()){
            $this->redirect('Mobile/Index/index');
        }
        return $this->fetch();
    }
}
