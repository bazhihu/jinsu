<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/3
 * Time: 17:54
 */
namespace api\modules\v1\controllers;

use backend\models\Comment;
use backend\models\Worker;
use backend\models\Workerother;
use common\models\Order;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;

class WorkerController extends ActiveController {
    public $modelClass = false;
    public $responseCode = 200;
    public $responseMsg = null;

    public static $commentOffset = 3;//三条评价
    public static $workerSelf = 2;//自我介绍

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
        return null;
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
        $worker = \api\modules\v1\models\Worker::formatWorker($worker);

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
        $worker = \api\modules\v1\models\Worker::formatWorker(['0'=>$worker]);
        $worker = $worker[0];

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
        $worker['selfIntros'] = $worker['selfIntros']?$worker['selfIntros']:[];
        #护工订单信息
        $worker['orders'] = Order::find()
            ->andFilterWhere(['worker_no'=>$worker_id])
            ->andFilterWhere(['order_status'=>Order::ORDER_STATUS_END_SERVICE])
            ->orderBy('order_id DESC')
            ->limit(self::$commentOffset)
            ->all();

        //护工排期
//        $worker['schedule'] = WorkerSchedule::find()
//            ->andFilterWhere(['worker_id'=>$worker_id])
//            ->orderBy('start_date ASC')
//            ->all();

        $worker['orders'] = $worker['orders']?$worker['orders']:[];
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