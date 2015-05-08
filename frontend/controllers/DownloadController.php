<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/5/8
 * Time: 10:44
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class DownloadController extends Controller{
    public function actionIndex(){
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ((preg_match("/(iphone|ipod|android)/i", $userAgent)) AND strstr($userAgent, 'webkit')){
            header('Location: http://m.youaiyihu.com/download.html');
            echo '<sctipt>location.href="http://m.youaiyihu.com/download.html"</sctipt>';
            return;
        }

        $this->_load();
    }

    private function _load(){
        $filename = Yii::$app->basePath.'/software/payment.zip';

        //文件的类型
        header('Content-type: application/zip');
        //下载显示的名字
        header('Content-Disposition: attachment; filename="filename.zip"');
        readfile("$filename");
    }
}