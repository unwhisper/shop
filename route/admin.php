<?php
/**
 * Created by PhpStorm.
 * Admin: jielei
 * Date: 2018.08.04
 * Time: 下午 3:08
 */
Route::group('admin',function (){
    Route::rule('welcome','admin/Admin/index');
    Route::rule('','admin/Admin/login');
    Route::rule('verify','admin/Admin/verify');
    Route::rule('test','admin/Admin/test');
    Route::rule('change','admin/Admin/change');
    Route::rule('showarticle/id/:id','admin/Admin/showArticle');
    Route::rule('showlist','admin/Admin/showList');
});

Route::group('home',function (){
    Route::rule('','admin/Index/index');
    Route::rule('welcome','admin/Index/welcome');
});

Route::group('system',function (){
    Route::rule('index/inc_type/:type','admin/System/index');
});

Route::group('uploadify',function (){
    Route::rule('upload/num/:num/input/:input/path/:path/func/:func/fileType/:fileType','admin/Uploadify/upload');
});

return [

];