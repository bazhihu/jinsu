<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%departments}}".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%departments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
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
            'name' => '科室名称',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * 获取科室列表
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
