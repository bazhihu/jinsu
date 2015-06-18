<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%Work_increment}}".
 *
 * @property string $id
 */
class WorkIncrement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_increment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }
}
