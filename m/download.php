<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/5/7
 * Time: 22:00
 */
    $filename = Yii::$app->basePath.'/web/payment.zip';
//文件的类型
    header('Content-type: application/zip');
//下载显示的名字
    header('Content-Disposition: attachment; filename="filename.zip"');
    readfile("$filename");
