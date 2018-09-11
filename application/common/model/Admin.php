<?php
namespace app\common\model;

use think\Model;

class Admin extends Model
{
    protected $pk = 'admin_id';

    protected $table = 'tp_admin';

    public function adminRole()
    {
        return $this->hasOne('AdminRole','role_id','role_id');
    }
}