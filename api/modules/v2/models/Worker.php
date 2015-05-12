<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/4
 * Time: 14:43
 */
namespace api\modules\v2\models;

use common\models\User;
use Yii;
use backend\models\City;
use backend\models\Departments;
use backend\models\Hospitals;
use backend\models\WorkerSchedule;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Config Model
 */
class Worker extends ActiveRecord
{
    #一组护工的个数
    public static $offset = 10;

    /**
     * 完善护工信息
     * @param $params
     * @return mixed
     */
    public static function formatWorker($params)
    {
        foreach($params as $key=>$value){
            $params[$key]['native_province'] = City::getCityName($value['native_province']);
            $params[$key]['nation']          = \backend\models\Worker::getNation($value['nation']);
            $params[$key]['chinese_level']   = \backend\models\Worker::getChineseLevel($value['chinese_level']);
            $params[$key]['education']       = \backend\models\Worker::getEducationLevel($value['education']);
            $params[$key]['certificate']     = \backend\models\Worker::getCertificateName($value['certificate']);
            $params[$key]['hospital_id']     = Hospitals::getHospitalsName($value['hospital_id']);
            $params[$key]['office_id']       = Departments::getDepartmentName($value['office_id']);
            $params[$key]['pic'] = \backend\models\Worker::workerPic($value['worker_id'], 120);
            unset($params[$key]['idcard'], $params[$key]['phone1'], $params[$key]['phone2']);
        }

        return $params;
    }

    /**
     * 护工筛选
     * @param $params
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function select($params){
        if(empty($params['page'])){
            $page = 0;
        }else{
            $page = $params['page']-1;
        }
        $perPage = 10;

        $worker = new \backend\models\Worker();
        $query = $worker::find();

        $countQuery = $worker::find();

        //获取在工作中的护工
        if(isset($params['start_time'])){
            $workerIds = WorkerSchedule::getWorkingByDate($params['start_time']);
            $query->andFilterWhere(['NOT IN', 'worker_id', $workerIds]);
            $countQuery->andFilterWhere(['NOT IN', 'worker_id', $workerIds]);
        }

        //医院
        if(isset($params['hospital_id'])){
            $query->andFilterWhere(['like', 'hospital_id', ','.$params['hospital_id'].',']);
            $countQuery->andFilterWhere(['like', 'hospital_id', ','.$params['hospital_id'].',']);
        }

        //科室
        if(!empty($params['department_id'])){
            $query->andFilterWhere(['like', 'office_id', ','.$params['department_id'].',']);
            $countQuery->andFilterWhere(['like', 'office_id', ','.$params['department_id'].',']);
        }

        $result = $query->offset($perPage*$page)
            ->limit($perPage)
            ->all();

        $totalCount = $countQuery->count();
        if(!empty($params['department_id']) && $totalCount == 0){
            unset($params['department_id']);
            return self::select($params);
        }
        $result = ArrayHelper::toArray($result);
        $meta = [
            'totalCount' => $totalCount,
            'pageCount' => ceil($totalCount/$perPage),
            'currentPage' => $page+1,
            'perPage' => $perPage
        ];
        return ['items' => $result, '_meta' => $meta];
    }

    public static function getMobile($comment){
        if(!empty($comment)){
            $comment = ArrayHelper::toArray($comment);
            foreach($comment as $key=>$val){
                $comment[$key]['mobile'] = substr_replace(User::findOne(['id'=>$val['uid']])->mobile,'****',3,4);
            }
            return $comment;
        }
        return [];
    }
}