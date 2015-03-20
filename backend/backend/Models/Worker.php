<?php

namespace app\backend\Models;

use Yii;

/**
 * This is the model class for table "yayh_worker".
 *
 * @property string $worker_id
 * @property string $name
 * @property integer $gender
 * @property string $birth
 * @property string $birth_place
 * @property string $native_province
 * @property integer $nation
 * @property integer $marriage
 * @property integer $education
 * @property integer $politics
 * @property string $idcard
 * @property integer $chinese_level
 * @property string $certificate
 * @property string $start_work
 * @property string $place
 * @property string $phone1
 * @property string $phone2
 * @property double $price
 * @property string $hospital_id
 * @property string $office_id
 * @property string $good_at
 * @property string $add_date
 * @property integer $adder
 * @property string $edit_date
 * @property integer $editer
 * @property string $total_score
 * @property integer $star
 * @property string $total_order
 * @property double $good_rate
 * @property string $total_comment
 * @property integer $level
 * @property integer $status
 */
class Worker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yayh_worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'nation', 'marriage', 'education', 'politics', 'chinese_level', 'phone1', 'phone2', 'adder', 'editer', 'total_score', 'star', 'total_order', 'total_comment', 'level', 'status'], 'integer'],
            [['birth', 'start_work', 'add_date', 'edit_date'], 'safe'],
            [['price', 'good_rate'], 'number'],
            [['name', 'idcard'], 'string', 'max' => 20],
            [['birth_place', 'native_province', 'hospital_id', 'office_id', 'good_at'], 'string', 'max' => 50],
            [['certificate'], 'string', 'max' => 10],
            [['place'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'worker_id' => 'Worker ID',
            'name' => 'Name',
            'gender' => 'Gender',
            'birth' => 'Birth',
            'birth_place' => 'Birth Place',
            'native_province' => 'Native Province',
            'nation' => 'Nation',
            'marriage' => 'Marriage',
            'education' => 'Education',
            'politics' => 'Politics',
            'idcard' => 'Idcard',
            'chinese_level' => 'Chinese Level',
            'certificate' => 'Certificate',
            'start_work' => 'Start Work',
            'place' => 'Place',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'price' => 'Price',
            'hospital_id' => 'Hospital ID',
            'office_id' => 'Office ID',
            'good_at' => 'Good At',
            'add_date' => 'Add Date',
            'adder' => 'Adder',
            'edit_date' => 'Edit Date',
            'editer' => 'Editer',
            'total_score' => 'Total Score',
            'star' => 'Star',
            'total_order' => 'Total Order',
            'good_rate' => 'Good Rate',
            'total_comment' => 'Total Comment',
            'level' => 'Level',
            'status' => 'Status',
        ];
    }
}
