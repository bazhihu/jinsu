<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%hospitals}}".
 *
 * @property string $id
 * @property string $name
 * @property string $province_id
 * @property string $city_id
 * @property string $area_id
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
            [['province_id'], 'required'],
            [['province_id', 'city_id', 'area_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
        ];
    }

    /**
     * 获取医院列表
     * @param int $provinceId 省ID
     * @param int $cityId 市ID
     * @param int $areaId 区县ID
     * @return static[]
     */
    static public function getList($provinceId = 110000, $cityId = 110100, $areaId = 0){
        $findArr = ['province_id' => $provinceId, 'city_id' => $cityId];
        if($areaId > 0){
            $findArr['area_id'] = $areaId;
        }

        return ArrayHelper::map(self::findAll($findArr), 'id', 'name');
    }
}
