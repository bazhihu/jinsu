<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%worker_increment}}".
 *
 * @property string $id
 */
class WorkerIncrement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_increment}}';
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
