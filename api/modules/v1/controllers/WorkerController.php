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
use backend\models\Comment;
use backend\models\Departments;
use backend\models\Hospitals;
use backend\models\WalletWithdrawcash;
use backend\models\Worker;
use backend\models\Workerother;
use backend\models\WorkerSearch;
use common\models\Order;
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

    public static $commentOffset = 3;//三条评价
    public static $workerSelf = 3;//自我介绍

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
     * 获取护工列表信息
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        //随机十个护工
        $params = Yii::$app->getRequest()->getBodyParams();
        $worker = \api\modules\v1\models\Worker::select($params);
        $worker = \api\modules\v1\models\Worker::spliceWorker($worker);
        if(!empty($worker)){

            foreach($worker as $key => $item){
                $item['pic'] = Worker::workerPic($item['worker_id']);
                $worker[$key] = $item;
            }
        }
        return $worker;
    }

    /**
     * 获取护工详细信息
     * @return array|null|static
     */
    public function actionView()
    {
        $worker_id  = Yii::$app->request->get('id');

        $worker = Worker::findOne(['worker_id'=>$worker_id]);
        $worker = ArrayHelper::toArray($worker);
        #拼接护工信息
        $worker = \api\modules\v1\models\Worker::spliceWorker(['0'=>$worker]);
        $worker = $worker[0];
        #护工头像
        if(!empty($worker)){
            $worker['pic'] = Worker::workerPic($worker['worker_id']);
        }
        #护工评价
        $worker['comments'] = Comment::find()
            ->andFilterWhere(['worker_id'=>$worker_id])
            ->orderBy('comment_id DESC')
            ->limit(self::$commentOffset)
            ->all();
        $worker['comments'] = \api\modules\v1\models\Worker::getMobile($worker['comments']);
        #护工自我介绍
        $worker['selfIntros'] = Workerother::find()
            ->andFilterWhere(['worker_id'=>$worker_id])
            ->andFilterWhere(['info_type'=>self::$workerSelf])
            ->all();
        $worker['selfIntros'] = $worker['selfIntros']?$worker['selfIntros']:'';
        #护工订单信息
        $worker['orders'] = Order::find()
            ->andFilterWhere(['order_status'=>Order::ORDER_STATUS_END_SERVICE])
            ->orderBy('order_id DESC')
            ->limit(self::$commentOffset)
            ->all();
        $worker['orders'] = $worker['orders']?$worker['orders']:"";
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