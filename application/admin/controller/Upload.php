<?php
/**
 * Created by PhpStorm.
 * User: leijie
 * Date: 2018/8/16 0016
 * Time: 16:31
 */

namespace app\admin\controller;

/**
 * 编辑器图片上传
 * Class Upload
 * @package app\admin\controller
 */
class Upload
{
    /**
     * 本地上传
     */
    public function upload()
    {
        //header("Content-Type:application/json; charset=utf-8"); // Unsupport IE
        header("Content-Type:text/html; charset=utf-8");
        header("Access-Control-Allow-Origin: *");

        error_reporting(E_ALL & ~E_NOTICE);

        $path     = env('root_path');
        $dir = $path . 'public/static/upload/product';
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $savePath = realpath($dir) . DIRECTORY_SEPARATOR;
        $saveURL  = '/static/upload/product/';

        //文件允许格式
        $formats  = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp')
        );

        //表单图片name
        $name = 'editormd-image-file';
        if (isset($_FILES[$name]))
        {
            $imageUploader = new \upload\EditorMdUploader($savePath, $saveURL, $formats['image'], 2,'32');  // Ymdhis表示按日期生成文件名，利用date()函数

            $imageUploader->config(array(
                'maxSize' => 1024,        // 允许上传的最大文件大小，以KB为单位，默认值为1024
                'cover'   => false         // 是否覆盖同名文件，默认为true
            ));
            if ($imageUploader->upload($name))
            {
                $imageUploader->message('上传成功！', 1);
            }
            else
            {
                $imageUploader->message('上传失败！', 0);
            }
        }
    }

    /**
     * 跨域上传
     */
    public function crossUpload()
    {
        header("Content-Type:text/html; charset=utf-8");
        header("Access-Control-Allow-Origin: *");

        error_reporting(E_ALL & ~E_NOTICE);

        $path     = env('root_path');
        $savePath = realpath($path . 'public/static/upload/product') . DIRECTORY_SEPARATOR;
        $saveURL  = 'http://'. $_SERVER['SERVER_NAME'] . '/static/upload/product/';   // 本例是演示跨域上传所以加上$_SERVER['SERVER_NAME']

        $formats  = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'webp')
        );

        $name        = 'editormd-image-file'; // file input name
        $callbackUrl = $_GET['callback'];

        if (isset($_FILES[$name]))
        {
            $imageUploader = new \upload\EditorMdUploader($savePath, $saveURL, $formats['image'], 2,'32');  // Ymdhis表示按日期生成文件名，利用date()函数

            $imageUploader->config(array(
                'maxSize' => 2048,        // 允许上传的最大文件大小，以KB为单位，默认值为1024
                'cover'   => false        // 是否覆盖同名文件，默认为true
            ));

            $imageUploader->redirect    = true;
            $imageUploader->redirectURL = $callbackUrl . (empty(parse_url($callbackUrl)['query']) ? '?' : '&') . 'dialog_id=' . $_GET['dialog_id'] . '&temp=' . date('ymdhis');

            if ($imageUploader->upload($name))
            {
                $imageUploader->message('上传成功！', 1);
            }
            else
            {
                $imageUploader->message('上传失败！', 0);
            }
        }
    }
}