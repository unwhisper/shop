<?php
/**
 * Created by PhpStorm.
 * User: jielei
 * Date: 2018.08.07
 * Time: 下午 8:46
 */

namespace app\model;

use think\Model;

class AdminRole extends Model
{
    protected $pk = 'role_id';

    protected $table = 'tp_admin_role';
}