<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/8/8 0008
 * Time: 14:20
 */

namespace app\common\facade;

use think\Facade;

class SC extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\controller\SC';
    }
}