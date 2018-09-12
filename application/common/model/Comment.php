<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/9/12
 * Time: 12:18
 */

namespace app\common\model;

use think\Model;

class Comment extends Model
{
    protected $pk = 'comment_id';

    protected $table = 'tp_comment';
}