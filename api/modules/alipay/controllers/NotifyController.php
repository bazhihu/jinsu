<?php
/**
 * 支付宝异步通知接口
 * User: zhangbo
 * Date: 2015/4/8
 * Time: 13:48
 */

namespace api\modules\alipay\controllers;

use yii\rest\ActiveController;

class NotifyController extends ActiveController
{
    public $modelClass = 'common\models\Order';

    public function actions(){
        return null;
    }
    public function actionCreate()
    {
        $post = Yii::$app->getRequest()->getBodyParams();

    }
}