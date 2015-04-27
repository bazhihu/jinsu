<?php

namespace backend\models;

use Yii;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%hospitals}}".
 *
 * @property string $id
 * @property string $name
 * @property string $province_id
 * @property string $city_id
 * @property string $area_id
 * @property string $phone
 */
class Hospitals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hospitals}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'name', 'phone'], 'required'],
            [['province_id', 'city_id', 'area_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '医院名称',
            'province_id' => '所属省份',
            'city_id' => '所属市',
            'area_id' => '所属区',
            'phone' => '医院电话',
        ];
    }

    /**
     * 获取医院列表
     * @param int $provinceId 省ID
     * @param int $cityId 市ID
     * @param int $areaId 区县ID
     * @return static[]
     * @author zhangbo
     */
    static public function getList($provinceId = 110000, $cityId = 110100, $areaId = 0)
    {
        $findArr = ['province_id' => $provinceId, 'city_id' => $cityId];
        if ($areaId > 0) {
            $findArr['area_id'] = $areaId;
        }

        return ArrayHelper::map(self::findAll($findArr), 'id', 'name');
    }

    /**
     * 获取医院名称
     * @param int $id
     * @return string
     * @author zhangbo
     */
    static function getName($id){
        return self::findOne($id)->name;
    }

    /**
     * 根据ID获取医院的NAME
     * @param string $IdStr
     * @return null|string
     */
    static public function getHospitalsName($IdStr){
        $ids = explode(',', $IdStr);
        if(empty($ids)) return null;

        $result = [];
        foreach ($ids as $id) {
            if(empty($id)) continue;
            $result[] = self::getName($id);
        }

        $data = implode('、', $result);

        return $data;
    }

    //获取医院电话
    static public function getHospitalPhone($id){
        $find = ['id' => $id];
        $call = self::findOne($find);
        if(!empty($call)) {
            return $call->phone;
        }
        return '';

    }
}
