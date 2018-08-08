<?php
//排除不需要验证登录
return [
    //admin模块
    'admin' =>[
        'index/login',
        'index/verify'
    ],
];