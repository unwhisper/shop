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
        $hot_goods = $hot_cate = $cateList = $recommend_goods = array();
        $sql = "select a.goods_name,a.goods_id,a.shop_price,a.market_price,a.cat_id,b.parent_id_path,b.name from ".Config::get('database.prefix')."goods as a left join ";
        $sql .= Config::get('database.prefix')."goods_category as b on a.cat_id=b.id where a.is_hot=1 and a.is_on_sale=1 order by a.sort";//二级分类下热卖商品
        $index_hot_goods = S('index_hot_goods');
        if(empty($index_hot_goods))
        {
            $index_hot_goods = Db::query($sql);//首页热卖商品
            S('index_hot_goods',$index_hot_goods,TPSHOP_CACHE_TIME);
        }

        if($index_hot_goods){
            foreach($index_hot_goods as $val){
                $cat_path = explode('_', $val['parent_id_path']);
                $hot_goods[$cat_path[1]][] = $val;
            }
        }

        $sql2 = "select a.goods_name,a.goods_id,a.shop_price,a.market_price,a.cat_id,b.parent_id_path,b.name from ".Config::get('database.prefix')."goods as a left join ";
        $sql2 .= Config::get('database.prefix')."goods_category as b on a.cat_id=b.id where a.is_recommend=1 and a.is_on_sale=1 order by a.sort";//二级分类下热卖商品
        $index_recommend_goods = S('index_recommend_goods');
        if(empty($index_recommend_goods))
        {
            $index_recommend_goods = Db::query($sql2);//首页推荐商品
            S('index_recommend_goods',$index_recommend_goods,TPSHOP_CACHE_TIME);
        }

        if($index_recommend_goods){
            foreach($index_recommend_goods as $va){
                $cat_path2 = explode('_', $va['parent_id_path']);
                $recommend_goods[$cat_path2[1]][] = $va;
            }
        }

        $hot_category = M('goods_category')->where("is_hot=1 and level=3 and is_show=1")->cache(true,TPSHOP_CACHE_TIME)->select();//热门三级分类
        foreach ($hot_category as $v){
            $cat_path = explode('_', $v['parent_id_path']);
            $hot_cate[$cat_path[1]][] = $v;
        }
        foreach ($this->cateTrre as $k=>$v){
            if($v['is_hot']==1){
                $v['hot_goods'] = empty($hot_goods[$k]) ? '' : $hot_goods[$k];
                $v['recommend_goods'] = empty($recommend_goods[$k]) ? '' : $recommend_goods[$k];
                $v['hot_cate'] = empty($hot_cate[$k]) ? array() : $hot_cate[$k];
                $cateList[]=$goods_category_tree[] = $v;
            }else{
                $goods_category_tree[] = $v;
            }
        }
        $this->assign('cateList',$cateList);
        $this->assign('goods_category_tree',$goods_category_tree);
        return $this->fetch();
    }
}
