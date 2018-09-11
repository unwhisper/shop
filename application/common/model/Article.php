<?php
/**
 * Created by PhpStorm.
 * User: jielei
 * Date: 2018.08.16
 * Time: 下午 8:18
 */

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $pk = 'id';

    protected $table = 'tp_article';

}