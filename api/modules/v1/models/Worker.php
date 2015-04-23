<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/4
 * Time: 14:43
 */
namespace api\modules\v1\models;

use common\models\User;
use Yii;
use backend\models\AdminUser;
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
     * @param bool $list 是否为列表
     * @return mixed
     */
    public static function spliceWorker($params,$list=true)
    {
        foreach($params as $key=>$value)
        {
            $params[$key]['native_province'] = $value['native_province']?City::findOne(['id'=>$value['native_province']])->name:'';
            $params[$key]['nation']          = $value['nation']?\backend\models\Worker::getNation($value['nation']):"";
            $params[$key]['chinese_level']   = $value['chinese_level']?\backend\models\Worker::getChineseLevel($value['chinese_level']):'';
            $params[$key]['education']       = $value['education']?\backend\models\Worker::getEducationLevel($value['education']):'';
            $params[$key]['certificate']     = $value['certificate']?\backend\models\Worker::getCertificateName($value['certificate']):'';
            $params[$key]['hospital_id']     = Hospitals::getHospitalsName($value['hospital_id']);
            $params[$key]['office_id']       = Departments::getDepartmentName($value['office_id']);

            /*if($value['birth']){
                $params[$key]['birth']                    = date('Y')-$value['birth'];
            }
            if($value['start_work']){
                $params[$key]['start_work']                = date('Y')-$value['start_work'];
            }

            if($value['pic'])
            {
                $params[$key]['pic'] =  'http://'.Yii::$app->params['pic_domain']."/uploads/".$value['worker_id'].".jpg";
            } else {
                $params[$key]['pic'] =  "uploads/no.jpg";
            }
            #详情
            if(!$list){
                $params[$key]['marriage']           = $value['marriage']=='1'?"已婚":'未婚';
                $params[$key]['nation']             = $value['nation']?\backend\models\Worker::getNation($value['nation']):"";
                $params[$key]['politics']           = $value['politics']?\backend\models\Worker::getPoliticsLevel($value['politics']):'';
                $params[$key]['chinese_level']      = $value['chinese_level']?\backend\models\Worker::getChineseLevel($value['chinese_level']):'';

                $params[$key]['good_at']            = Departments::getDepartmentName($value['good_at']);
                $params[$key]['birth_place']        = City::getCityName($value['birth_place']);
                $params[$key]['adder']              = AdminUser::getInfo($value['adder']);
            }*/

        }

        return $params;
    }

    /**
     * 护工筛选
     * @param $params
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function select($params)
    {
        if(!isset($params['start_time'])){
            $params['start_time'] = '';
        }
        //获取在工作中的护工
        $workerIds = WorkerSchedule::getWorkingByDate($params['start_time']);

        $worker = new \backend\models\Worker();
        $query = $worker->find();

        $birth = null;
        if(!empty($params['birth'])){
            $birth = date('Y')-$params['birth'];
        }

        $query->andFilterWhere([
            'gender'            => !empty($params['gender'])?$params['gender']:'',
            'birth'             => $birth,
            'native_province'   => !empty($params['native_province'])?$params['native_province']:'',
            'level'             => !empty($params['level'])?$params['level']:'',
            'status'            => !empty($params['status'])?$params['status']:'',
            'chinese_level'     => !empty($params['chinese_level'])?$params['chinese_level']:'',
            'star'              => !empty($params['star'])?$params['star']:'',
        ]);

        if(!empty($workerIds)){
            $query->andFilterWhere(['NOT IN', 'worker_id', $workerIds]);
        }

        $query->andFilterWhere(['like', 'worker_id', !empty($params['worker_id'])?$params['worker_id']:''])
            ->andFilterWhere(['like', 'name', !empty($params['name'])?$params['name']:''])
            ->andFilterWhere(['like', 'hospital_id', !empty($params['hospital_id']) ? ','.$params['hospital_id'].',':''])
            ->andFilterWhere(['like', 'office_id', !empty($params['office_id']) ? ','.$params['office_id'].',':''])
            ->andFilterWhere(['like', 'good_at', !empty($params['good_at'])? ','.$params['good_at'].',':'']);

        $count = $query->count();
        if($count>self::$offset)
        {
            $query->limit(self::$offset)->offset(mt_rand(0,$count-self::$offset));
        }

        return $query->all();
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