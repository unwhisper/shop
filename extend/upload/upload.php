<?php

    //header("Content-Type:application/json; charset=utf-8"); // Unsupport IE
    header("Content-Type:text/html; charset=utf-8");
    header("Access-Control-Allow-Origin: *");

    require("EditorMdUploader.php");

    error_reporting(E_ALL & ~E_NOTICE);
	
	$path     = __DIR__ . DIRECTORY_SEPARATOR;var_dump($path);
	$url      = dirname($_SERVER['PHP_SELF']) . '/';var_dump($url);
	$savePath = realpath($path . '../uploads/') . DIRECTORY_SEPARATOR;var_dump($savePath);
	$saveURL  = $url . '../uploads/';var_dump($saveURL);exit;

	$formats  = array(
		'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp')
	);

    $name = 'editormd-image-file';
    if (isset($_FILES[$name]))
    {        
        $imageUploader = new EditorMdUploader($savePath, $saveURL, $formats['image'], 2,'32');  // Ymdhis表示按日期生成文件名，利用date()函数
        
        $imageUploader->config(array(
            'maxSize' => 2048,        // 允许上传的最大文件大小，以KB为单位，默认值为1024
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
?>