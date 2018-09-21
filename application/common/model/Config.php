<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/21
 * Time: 11:30
 */

namespace app\common\model;

use think\Model;

class Config extends Model
{
    protected $pk = 'id';

    protected $table = 'tp_config';
}