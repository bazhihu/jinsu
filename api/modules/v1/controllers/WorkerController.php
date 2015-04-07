<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/3
 * Time: 17:54
 */
namespace api\modules\v1\controllers;

use backend\models\AdminUser;
use backend\models\City;
use backend\models\Departments;
use backend\models\Hospitals;
use backend\models\WalletWithdrawcash;
use backend\models\Worker;
use backend\models\WorkerSearch;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class WorkerController extends ActiveController {
    public $modelClass = '';
    public $responseCode = 200;
    public $responseMsg = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return ArrayHelper::merge($behaviors, [
            'authenticator' => [
                //'class' => HttpBearerAuth::className()
            ],
        ]);
    }
    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" actions
        unset($actions['index'], $actions['view'], $actions['delete'], $actions['create'] ,$actions['update'] ,$actions['options']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        //$actions['index']['prepareDataProvider'] = [$this, 'index'];
        return $actions;
    }

    /**
     * list
     */
    public function actionIndex()
    {
        //随机十个护工
        $params = Yii::$app->getRequest()->getBodyParams();
        $params['start_time'] = '2014-05-12';
        $worker = \api\modules\v1\models\Worker::select($params);

        $worker = \api\modules\v1\models\Worker::spliceWorker($worker);
        return $worker;
    }

    /**
     * read
     */
    public function actionView()
    {
        $worker_id = Yii::$app->request->get('id');

        $worker = Worker::findOne(['worker_id'=>$worker_id]);

        $worker = \api\modules\v1\models\Worker::spliceWorker(['0'=>$worker]);
        return $worker;
    }

    /**
     * 返回数据处理
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $response = [
            'code' => $this->responseCode,
            'msg' => $this->responseMsg,
            'data' => null
        ];
        $result = parent::afterAction($action, $result);
        $response['data'] = $result;
        return $this->serializeData($response);
    }
}