<?php
/**
 * Created by PhpStorm.
 * Admin: jielei
 * Date: 2018.08.04
 * Time: 下午 3:07
 */

Route::rule('','index/Index/index');
Route::group('index',function (){

});
Route::group('api',function (){
    Route::rule('getregion/level/2/parent_id/:id','index/Api/getRegion');
});

return [

];