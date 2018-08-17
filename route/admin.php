<?php
/**
 * Created by PhpStorm.
 * Admin: jielei
 * Date: 2018.08.04
 * Time: 下午 3:08
 */
Route::group('admin',function (){
    Route::rule('','admin/Index/index');
    Route::rule('login','admin/Index/login');
    Route::rule('verify','admin/Index/verify');
    Route::rule('test','admin/Index/test');
    Route::rule('change','admin/Index/change');
    Route::rule('showarticle/id/:id','admin/Index/showArticle');
    Route::rule('showlist','admin/Index/showList');
});

return [

];