<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%hospital_department_relation}}".
 *
 * @property string $id
 * @property string $hospital_id
 * @property string $department_id
 */
class HospitalDepartmentRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hospital_department_relation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hospital_id', 'department_id'], 'required'],
            [['id', 'hospital_id', 'department_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'hospital_id' => '医院编号',
            'department_id' => '科室编号',
        ];
    }
}
