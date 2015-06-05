<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/4
 * Time: 14:43
 */
namespace api\modules\v2\models;

use Yii;
use backend\models\City;
use backend\models\Departments;
use backend\models\Hospitals;

/**
 * Config Model
 */
class Order extends \common\models\Order{
    static public function format($data){
        if(!empty($data)){
            foreach($data as $key => $item){
                $item['pic'] = \backend\models\Worker::workerPic($item['worker_no']);
                $item['hospital_id'] = Hospitals::getName($item['hospital_id']);
                $item['department_id'] = Departments::getName($item['department_id']);
                $item['worker_level_name'] = \backend\models\Worker::getWorkerLevel($item['worker_level']);
                $item['city_name'] = City::getCityName($item['city_id']);

                $result[$key] = $item;
            }
        }

        return $data;
    }
}