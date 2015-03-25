<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%holidays}}".
 *
 * @property string $id
 * @property string $date
 */
class Holidays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holidays}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => '节假日',
        ];
    }
}
