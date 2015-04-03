<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/3
 * Time: 14:25
 */
namespace api\modules\v1\controllers;

use backend\models\Departments;
use backend\models\Holidays;
use backend\models\Hospitals;
use backend\models\OrderPatient;
use backend\models\Worker;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ConfigController extends ActiveController {
    public $modelClass = 'backend\models\Hospitals';
    public $responseCode = 200;
    public $responseMsg = null;

    /**
     * 患者描述
     * @var array
     */
    private static $patientDes = [
        OrderPatient::PATIENT_STATE_OK          =>'自己吃饭,自己走路,自己上厕所',
        OrderPatient::PATIENT_STATE_DISABLED    =>'不能自己吃饭,不能自己走路,不能自己上厕所',
    ];
    /**
     * 护工等级描述
     * @var array
     */
    private static $workerDes = [
        Worker::WORKER_LEVEL_MEDIUM =>'3年工作经验',
        Worker::WORKER_LEVEL_HIGH   =>'5年工作经验',
        Worker::WORKER_LEVEL_SUPER  =>'7年工作经验',
    ];
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


    public function actionIndex()
    {

        $return  = array();
        #医院
        $return['hospitals'] =Hospitals::find()->all();
        foreach($return['hospitals'] as $hospitals)
        {
            unset($hospitals['province_id']);
            unset($hospitals['city_id']);
            unset($hospitals['area_id']);
            unset($hospitals['phone']);
        }
        #科室
        $return['departments'] = Departments::find()->all();
        foreach($return['departments'] as $departments)
        {
            unset($departments['parent_id']);
        }
        #护工等级
        $return['worker_levels'] = self::generateWorker([Worker::WORKER_LEVEL_MEDIUM,Worker::WORKER_LEVEL_HIGH,Worker::WORKER_LEVEL_SUPER]);

        #患者等级
        $return['patient_states'] = self::generatePatient([OrderPatient::PATIENT_STATE_OK,OrderPatient::PATIENT_STATE_DISABLED]);
        $return['holidays'] = ArrayHelper::getColumn(Holidays::find()->all(),'date');
        return $return;
    }

    /**
     *获取患者等级数组
     * @param $array
     * @return array
     */
    protected static function generatePatient($array)
    {
        $return = array();
        foreach($array as $key=>$value)
        {
            $return[$key] = [
                "id"    => $value,
                "name"  => OrderPatient::$patientStateLabels[$value],
                "des"   => self::$patientDes[$value],
                "price" => intval(OrderPatient::$patientStatePrice[$value]*100),
            ];
        }
        return $return;
    }

    /**
     * 获取护工等级数组
     * @param $array
     * @return array
     */
    protected static function generateWorker($array)
    {
        $return = array();
        foreach($array as $key=>$value)
        {
            $return[$key] = [
                "id"    => $value,
                "name"  => Worker::$workerLevelLabel[$value],
                "des"   => self::$workerDes[$value],
                "price" => Worker::$workerPrice[$value],
            ];
        }
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