<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/4
 * Time: 11:45
 */

namespace api\modules\v2\models;

use \yii\db\ActiveRecord;
use backend\models\Worker;
use backend\models\OrderPatient;
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
        Worker::WORKER_LEVEL_PRIMARY =>'3年工作经验',
        Worker::WORKER_LEVEL_MEDIUM =>'5年工作经验',
        Worker::WORKER_LEVEL_HIGH   =>'7年工作经验',
        Worker::WORKER_LEVEL_SUPER  =>'8年工作经验',
    ];

    /**
     *获取患者等级数组
     * @param $array
     * @return array
     */
    public static function generatePatient($array)
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
    public static function generateWorker($array)
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
}
