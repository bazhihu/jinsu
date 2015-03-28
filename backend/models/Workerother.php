<?php

namespace backend\Models;

use Yii;

/**
 * This is the model class for table "{{%workerother}}".
 *
 * @property string $worker_id
 * @property string $ext1
 * @property string $ext2
 * @property string $ext3
 * @property string $ext4
 * @property integer $info_type
 */
class Workerother extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workerother}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id'], 'required'],
            [['worker_id', 'info_type'], 'integer'],
            [['ext1', 'ext2', 'ext3', 'ext4'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'worker_id' => '护工id',
            'ext1' => '字段1',
            'ext2' => '字段2',
            'ext3' => '字段3',
            'ext4' => '字段四',
            'info_type' => '类型：1工作经历 2：家庭成员 3：自我介绍 4：紧急联系人',
        ];
    }

    /**
     * 添加护工其他信息
     * @param $sql
     */
    static  public function workerOtherAdd($sql){
        $connection = Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->query();
    }
}