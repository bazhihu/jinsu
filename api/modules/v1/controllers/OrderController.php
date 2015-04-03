<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 0:31
 */

namespace api\modules\v1\controllers;

use common\models\Order;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use backend\models\Worker;

class OrderController extends ActiveController {
    public $modelClass = 'common\models\Order';
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
        unset($actions['index'], $actions['view'], $actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        //$actions['index']['prepareDataProvider'] = [$this, 'index'];
        return $actions;
    }

    /**
     * 订单列表
     * @param $uid
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionIndex($uid){
        $query = Order::find()
            ->andFilterWhere(['uid' => $uid])
            ->orderBy(['order_id' => SORT_DESC])->all();
        $result = ArrayHelper::toArray($query);
        if(!empty($query)){
            foreach($result as $key => $item){
                $item['pic'] = Worker::workerPicByWorkerId($item['worker_no']);
                $result[$key] = $item;
            }
        }
        return $result;
    }

    /**
     * @return null|static
     */
    public function actionView(){
        $order_no = Yii::$app->request->get('id');
        $query = Order::findOne(['order_no' => $order_no]);
        $result = ArrayHelper::toArray($query);
        $result['pic'] = null;
        if(!empty($result['worker_no'])){
            //获取护工照片
            $result['pic'] = Worker::workerPicByWorkerId($result['worker_no']);
        }
        return $result;
    }

    /**
     * 创建订单
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionCreate(){
        $params = Yii::$app->getRequest()->getBodyParams();
        $orderModel = new Order();
        if($orderModel->load($params)){
            $orderModel->createOrder($params);
            print_r($orderModel);
        }else{
            echo 'error';
        }


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