<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/3
 * Time: 17:54
 */
namespace api\modules\v2\controllers;

use backend\models\Patient;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;


class PatientController extends ActiveController {
    public $modelClass = false;
    public $responseCode = 200;
    public $responseMsg = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];

        return ArrayHelper::merge($behaviors, [
            'authenticator' => [
                //'class' => QueryParamAuth::className()
            ],
        ]);
    }
    public function actions()
    {
        return null;
    }

    /**
     * 获取患者列表
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($user_id){
        $patient = null;
        $patient = Patient::findAll(['user_id' => $user_id]);

        return $patient;
    }

    /**
     * 添加患者信息
     * @return null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        $post = Yii::$app->getRequest()->getBodyParams();
        $patientModel = new Patient();
        $patientModel->setAttributes($post);

        if(!$patientModel->save()){
            $this->responseCode = 400;
            $this->responseMsg = print_r($patientModel->getErrors(), true);
            return null;
        }
        $this->responseMsg = '添加成功';
    }

    /**
     * 修改患者信息
     * @return null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(){
        $id = Yii::$app->request->get('id');
        $patient = Patient::findOne($id);
        if(empty($patient)){
            $this->responseCode = 404;
            $this->responseMsg = '找不到患者信息';
            return null;
        }

        $params = Yii::$app->getRequest()->getBodyParams();
        $patient->setAttributes($params);
        if(!$patient->save()){
            $this->responseCode = 400;
            $this->responseMsg = print_r($patient->getErrors(), true);
            return null;
        }
        $this->responseMsg = '修改成功';
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function actionDelete(){
        $id = Yii::$app->request->get('id');
        if(!Patient::findOne($id)->delete()){
            $this->responseCode = 400;
            $this->responseMsg = '删除失败';
            return null;
        }
        $this->responseMsg = '删除成功';
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