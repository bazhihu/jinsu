<?php

namespace backend\models;

use Yii;

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
}
