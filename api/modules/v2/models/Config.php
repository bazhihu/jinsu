<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/4
 * Time: 11:45
 */

namespace api\modules\v2\models;

use backend\models\City;
use \yii\db\ActiveRecord;
use backend\models\Worker;
use backend\models\OrderPatient;
use yii\helpers\ArrayHelper;

/**
 * Config Model
 */
class Config extends ActiveRecord
{
    /**
     * 患者描述
     * @var array
     */
    public static $patientDes = [
        OrderPatient::PATIENT_STATE_OK          =>'指行动不需要协助可自行解决的病患，如：可自行行走、吃饭、排便并意识清醒',
        OrderPatient::PATIENT_STATE_DISABLED    =>'指行动完全需要协助来完成的病患，如：不可行走、吃饭、排便或昏迷',
    ];
    /**
     * 护工等级描述
     * @var array
     */
    public static $workerDes = [
        Worker::WORKER_LEVEL_NEW =>'0年工作经验',
        Worker::WORKER_LEVEL_PRIMARY =>'3年工作经验',
        Worker::WORKER_LEVEL_MEDIUM =>'5年工作经验',
        Worker::WORKER_LEVEL_HIGH   =>'7年工作经验',
        Worker::WORKER_LEVEL_SUPER  =>'8年工作经验',
    ];


    /**
     * 获取护工等级数组
     * @return array
     */
    public static function getWorkerLevels(){
        $return = array();
        foreach(array_keys(Worker::$workerLevelLabel) as $value){
            $return[] = [
                "id"    => $value,
                "name"  => Worker::$workerLevelLabel[$value],
                "des"   => self::$workerDes[$value],
                "price" => Worker::$workerPrice[$value],
            ];
        }
        return $return;
    }

    /**
     * 获取有护工的省份
     * @param $cityId
     * @return array
     */
    public static function getHaveWorkerProvinces($cityId){
        $connection = \Yii::$app->db;
        $sql = "SELECT native_province FROM yayh_worker WHERE city_id=$cityId AND audit_status=1";
        $sql = "SELECT `id`,`name` FROM yayh_city WHERE `id` IN($sql)";
        $command = $connection->createCommand($sql);
        $provinces = $command->queryAll();
        return $provinces;
    }
}
