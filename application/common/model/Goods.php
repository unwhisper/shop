<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/11
 * Time: 14:49
 */

namespace app\common\model;

use think\Model;

class Goods extends Model
{
    protected $pk = 'goods_id';

    protected $table = 'tp_goods';

    public function goodsCategory()
    {
        return $this->hasOne('goodsCategory','cat_id','id');
    }
}