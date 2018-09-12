<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/12
 * Time: 10:15
 */

namespace app\common\model;

use think\Model;

class Order extends Model
{
    protected $pk = 'order_id';

    protected $table = 'tp_order';
}