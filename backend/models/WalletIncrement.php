<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%wallet_increment}}".
 *
 * @property string $id
 */
class WalletIncrement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_increment}}';
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
