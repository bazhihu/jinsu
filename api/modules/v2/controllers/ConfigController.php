<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/3
 * Time: 14:25
 */
namespace api\modules\v2\controllers;

use api\modules\v2\models\Config;
use backend\models\Departments;
use backend\models\Holidays;
use backend\models\Hospitals;
use backend\models\OrderPatient;
use backend\models\Worker;
use backend\models\City;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;

class ConfigController extends ActiveController {
    public $modelClass = FALSE;
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


    public function actionIndex(){
        $cityId = Yii::$app->request->get('city_id');
        $return = array();

        #医院
        if(empty($cityId)){
            $cityId = 110100;
        }
        $columns = ['id','name','province_id','city_id','area_id','pinyin'];
        $return['hospitals'] = Hospitals::find()->select($columns)->where(['city_id'=>$cityId])->all();

        #科室
        $return['departments'] = Departments::find()->all();

        #护工等级
        $return['worker_levels'] = Config::getWorkerLevels();

        #节假日
        $return['holidays'] = ArrayHelper::getColumn(Holidays::find()->all(), 'date');

        //开通城市
        $return['open_cities'] = City::getList(null, 3, false);

        //省份列表
        $return['provinces'] = City::getList(1, 2, false);

        //区域
        $return['areas'] = City::getList($cityId, null, false);

        return $return;
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