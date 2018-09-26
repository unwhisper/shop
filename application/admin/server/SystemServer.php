<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/21
 * Time: 11:04
 */

namespace app\admin\server;

//use app\common\model\Config;
use app\common\model\Region;
//use think\facade\Cache;

class SystemServer
{
/*    /**
     * 系统配置
     * @param $inc_type
     * @param array $data
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
    public function configCache($inc_type,$data = array())
    {
        $param = explode('.', $inc_type);
        if (empty($data)){
            $config = Cache::get($param[0]);
            if (empty($config)){
                $res = Config::where('inc_type',$param[0])->select();
                if ($res){
                    foreach($res as $k=>$val){
                        $config[$val['name']] = $val['value'];
                    }
                    Cache::set($param[0],$config);
                }
            }
            if(count($param)>1){
                return $config[$param[1]];
            }else{
                return $config;
            }
        }else{
            $result = Config::where('inc_type',$param[0])->select();
            if ($result){
                foreach($result as $val){
                    $temp[$val['name']] = $val['value'];
                }
                foreach ($data as $k=>$v){
                    $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
                    if(!isset($temp[$k])){
                        Config::create($newArr);//新key数据插入数据库
                    }else{
                        if($v!=$temp[$k])
                            Config::where("name", $k)->update($newArr);//缓存key存在且值有变更新此项
                    }
                }
                //更新后的数据库记录
                $newRes = Config::where('inc_type',$param[0])->select();
                foreach ($newRes as $rs){
                    $newData[$rs['name']] = $rs['value'];
                }
            }else{
                foreach($data as $k=>$v){
                    $newArr[] = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
                }
                Config::insertAll($newArr);
                $newData = $data;
            }
            Cache::set($param[0],$newData);
        }
    }*/

    public function getProvince($province)
    {
        $city = Region::where('parent_id',$province)->select();
        if ($city){
            return $city->toArray();
        }else{
            return false;
        }
    }
}