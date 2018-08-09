<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/8/9 0009
 * Time: 16:33
 */

namespace app\common\controller;


class RedisServer
{
    private static $redis;

    //当前数据库ID号
    protected $dbId=0;

    //当前权限认证码
    protected $auth;

    /**
     * 实例化的对象,单例模式.
     * @var \iphp\db\Redis
     */
    static private $_instance = null;

    //连接属性数组
    protected $attr=array(
        //连接超时时间，redis配置文件中默认为300秒
        'timeout'=>60,
        //选择的数据库。
        'db_id'=>0,
    );

    //什么时候重新建立连接
    protected $expireTime;

    //ip
    protected $host;

    //端口
    protected $port;

    public function __construct($config,$attr=array())
    {
        $this->attr = array_merge($this->attr,$attr);
        self::$redis = new \Redis();
        $this->port = $config['port'];
        $this->host = $config['host'];
        self::$redis->pconnect($this->host,$this->port,$this->attr['timeout']);

        if(isset($config['auth']))
        {
            $this->auth($config['auth']);
            $this->auth = $config['auth'];
        }
        if ($this->attr['db_id'] != 0){
            self::$redis->select($this->attr['db_id']);
            $this->dbId = $this->attr['db_id'];
        }
        $this->expireTime = time() + $this->attr['timeout'];
    }

    //单例模式
    public static function getInstance($config=array('host' => '127.0.0.1', 'port' => 6379),$attr=array())
    {
        //如果是一个字符串，将其认为是数据库的ID号。以简化写法。
        if(is_numeric($attr))
        {
            $dbId = $attr;
            $attr = array();
            $attr['db_id'] = $dbId;
        }

        try{
            if (isset(self::$_instance[$db]) && self::$_instance[$db]->Ping() == 'Pong') {
                return self::$_instance[$db];
            }
        } catch (Exception $e) {
        }
        if(!isset(self::$_instance))
        {
            self::$_instance = new self($config,$attr);
        }
        elseif( time() > self::$_instance->expireTime)
        {
            self::$_instance->close();
            self::$_instance = new self($config,$attr);
        }
        return self::$_instance;
    }

    private function __clone(){}

    //获取连接信息
    public function getInfo()
    {
        $info = array();
        $info['db_id'] = $this->dbId;
        $info['host'] = $this->host;
        $info['port'] = $this->port;
        $info['timeout'] = $this->attr['timeout'];
        $info['expire_time'] = date('Y-m-d H:i:s',$this->expireTime);
        return $info;
    }

    /**
     * 执行原生的redis操作
     * @return \Redis
     */
    public function getRedis()
    {
        return self::$redis;
    }

    /*------------------------------------start 1.string结构----------------------------------------------------*/
    /**
     * 增，设置值  构建一个字符串
     * @param string $key KEY名称
     * @param string $value  设置值
     * @param int $timeOut 时间  0表示无过期时间
     * @return true【总是返回true】
     */
    public function set($key, $value, $timeOut=0) {
        $setRes =  self::$redis->set($key, $value);
        if ($timeOut > 0) self::$redis->expire($key, $timeOut);
        return $setRes;
    }
}