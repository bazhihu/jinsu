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
class Worker extends ActiveRecord{
    #一组护工的个数
    public static $offset = 10;

    /**
     * 护工筛选
     * @param array $params
     * @param array $workerIds
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function select($params, $workerIds){
        if(empty($params['page'])){
            $page = 0;
        }else{
            $page = $params['page']-1;
        }
        $perPage = 10;

        //城市
        if(empty($params['city_id'])){
            $cityId = 110100;
        }else{
            $cityId = $params['city_id'];
        }

        $worker = new \backend\models\Worker();
        $query = $worker::find();
        $countQuery = $worker::find();

        $query->andFilterWhere(['audit_status' => 1, 'status' => 1, 'city_id' => $cityId]);
        $countQuery->andFilterWhere(['audit_status' => 1, 'status' => 1, 'city_id' => $cityId]);

        //获取在工作中的护工
        if(isset($params['free']) && $params['free'] == 'yes'){
            $query->andFilterWhere(['NOT IN', 'worker_id', $workerIds]);
            $countQuery->andFilterWhere(['NOT IN', 'worker_id', $workerIds]);
        }

        //医院
        if(!empty($params['hospital_id'])){
            $query->andFilterWhere(['like', 'hospital_id', ','.$params['hospital_id'].',']);
            $countQuery->andFilterWhere(['like', 'hospital_id', ','.$params['hospital_id'].',']);
        }

        //科室
//        if(!empty($params['department_id'])){
//            $query->andFilterWhere(['like', 'office_id', ','.$params['department_id'].',']);
//            $countQuery->andFilterWhere(['like', 'office_id', ','.$params['department_id'].',']);
//        }

        //籍贯
        if(!empty($params['native_province'])){
            $query->andFilterWhere(['native_province' => $params['native_province']]);
            $countQuery->andFilterWhere(['native_province' => $params['native_province']]);
        }

        //性别
        if(!empty($params['gender'])){
            $query->andFilterWhere(['gender' => $params['gender']]);
            $countQuery->andFilterWhere(['gender' => $params['gender']]);
        }

        //护工等级
        if(!empty($params['worker_level'])){
            $query->andFilterWhere(['level' => $params['worker_level']]);
            $countQuery->andFilterWhere(['level' => $params['worker_level']]);
        }

        $totalCount = $countQuery->count();
        if(!empty($params['hospital_id']) && $totalCount == 0){
            unset($params['hospital_id']);
            return self::select($params, $workerIds);
        }

        //排序
        $orderBy = 'star DESC';

        if(isset($params['sort'])){
            //价格排序，高到低
            if($params['sort'] == 'price_down'){
                $orderBy = 'price DESC';
            }
            //价格排序，低到高
            if($params['sort'] == 'price_up'){
                $orderBy = 'price ASC';
            }

            //星级，高到低
            if($params['sort'] == 'star_down'){
                $orderBy = 'star DESC';
            }
            //星级，低到高
            if($params['sort'] == 'star_up'){
                $orderBy = 'star ASC';
            }

            //护理经验，高到低
            if($params['sort'] == 'start_work_down'){
                $orderBy = 'start_work DESC';
            }
            //护理经验，低到高
            if($params['sort'] == 'start_work_up'){
                $orderBy = 'start_work ASC';
            }

            //出生日期，大到小
            if($params['sort'] == 'birth_down'){
                $orderBy = 'birth DESC';
            }

            //出生日期，小到大
            if($params['sort'] == 'birth_up'){
                $orderBy = 'birth ASC';
            }

            //积分，高到低
            if($params['sort'] == 'score_down'){
                $orderBy = 'total_score DESC';
            }
            //积分，低到高
            if($params['sort'] == 'score_up'){
                $orderBy = 'total_score ASC';
            }
        }

        $result = $query->offset($perPage*$page)
            ->limit($perPage)
            ->orderBy($orderBy)
            ->all();

        $result = ArrayHelper::toArray($result);
        $meta = [
            'totalCount' => $totalCount,
            'pageCount' => ceil($totalCount/$perPage),
            'currentPage' => $page+1,
            'perPage' => $perPage
        ];
        return ['items' => $result, '_meta' => $meta];
    }

    /**
     * 完善护工信息
     * @param array $params
     * @param array $workerIds
     * @return mixed
     */
    public static function formatWorker($params, $workerIds = []){

        foreach($params as $key=>$value){
            $params[$key]['native_province'] = City::getCityName($value['native_province']);
            $params[$key]['nation']          = \backend\models\Worker::getNation($value['nation']);
            $params[$key]['chinese_level']   = \backend\models\Worker::getChineseLevel($value['chinese_level']);
            $params[$key]['education']       = \backend\models\Worker::getEducationLevel($value['education']);
            $params[$key]['certificate']     = \backend\models\Worker::getCertificateName($value['certificate']);
            $params[$key]['level_name']      = \backend\models\Worker::getWorkerLevel($value['level']);
            $params[$key]['level_des']       = \backend\models\Worker::getWorkerLevelDescription($value['level']);
            $params[$key]['city_id']         = City::getCityName($value['city_id']);
            $params[$key]['hospital_id']     = Hospitals::getHospitalsName($value['hospital_id']);
            $params[$key]['office_id']       = Departments::getDepartmentNames($value['office_id']);
            $params[$key]['pic'] = \backend\models\Worker::workerPic($value['worker_id'], 120);
            $params[$key]['in_service']      = in_array($value['worker_id'], $workerIds);
            unset($params[$key]['idcard'], $params[$key]['phone1'], $params[$key]['phone2']);
        }

        return $params;
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