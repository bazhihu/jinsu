<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/2
 * Time: 21:58
 */

namespace api\modules\v1\controllers;

use yii\web\Response;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;

class UserController extends ActiveController{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return ArrayHelper::merge($behaviors, [
            'authenticator' => [
                //'class' => HttpBasicAuth::className(),
            ],
        ]);
    }
    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" actions
        unset($actions['delete'], $actions['index']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        //$actions['index']['prepareDataProvider'] = [$this, 'index'];

        return $actions;
    }
}