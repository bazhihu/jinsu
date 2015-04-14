<?php
/**
 * 支付宝异步通知接口
 * User: zhangbo
 * Date: 2015/4/8
 * Time: 13:48
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;

class AlipayController extends ActiveController
{
    public $modelClass = false;

    public function actions(){
        return null;
    }
    public function actionCreate()
    {
        $post = Yii::$app->getRequest()->getBodyParams();
        Yii::info(print_r($post, true));

        print_r($post);
        exit;


    }
    public function actionNotify(){
        echo 'notify';exit;
    }
}