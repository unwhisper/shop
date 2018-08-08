<?php
namespace app\index\controller;

use app\admin\controller\Common;
use think\Controller;

class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }
}
