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
        print_r(Yii::$app->getRequest());
        exit;
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