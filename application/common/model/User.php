<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/12
 * Time: 12:10
 */

namespace app\common\model;

use think\Model;

class User extends Model
{
    protected $pk = 'user_id';

    protected $table = 'tp_users';
}