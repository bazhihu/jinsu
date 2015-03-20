<?php

namespace backend\Models;

use Yii;

/**
 * This is the model class for table "{{%worker}}".
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
        return '{{%worker}}';
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
            [['name', 'idcard','native_province'], 'string', 'max' => 20],
            [['birth_place','hospital_id', 'office_id', 'good_at'], 'string', 'max' => 50],
            [['place'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'worker_id' => '护工编号',
            'name' => '姓名',
            'gender' => '性别',
            'birth' => '出生日期',
            'birth_place' => '户口所在地',
            'native_province' => '籍贯',
            'nation' => '民族',
            'marriage' => '婚姻状况',
            'education' => '文化程度',
            'politics' => '政治面貌',
            'idcard' => '身份证号',
            'chinese_level' => '普通话水平',
            'certificate' => '资质证书',
            'start_work' => '入行时间',
            'place' => '居住地',
            'phone1' => '手机号',
            'phone2' => '手机号',
            'price' => '服务价格',
            'hospital_id' => '常驻医院',
            'office_id' => '常驻科室',
            'good_at' => '擅长护理的疾病',
            'add_date' => '添加时间',
            'adder' => '添加人',
            'edit_date' => '编辑时间',
            'editer' => '编辑人',
            'total_score' => '积分总数',
            'star' => '星级',
            'total_order' => '总订单数',
            'good_rate' => '好评率',
            'total_comment' => '评论总数',
            'level' => '护工等级',
            'status' => '工作状态',
        ];
    }

    /**
     * @worker_age :通过护工出生日期换算年龄
     */
    public function worker_age($birth=''){
        $age = date('Y', time()) - date('Y', strtotime($birth)) - 1;
        if (date('m', time()) == date('m', strtotime($birth))){
            if (date('d', time()) > date('d', strtotime($birth))){
                $age++;
            }
        }elseif (date('m', time()) > date('m', strtotime($birth))){
            $age++;
        }
        return $age;
    }


    /**
     * @worker_age :星级
     */
    public function worker_star($star=5){
        if($star>=4.5){
            $star_str = '5';
        }elseif(4.5>$star && $star>=4){
            $star_str = '4.5';
        }elseif(4>$star && $star>=3.5){
            $star_str = '4';
        }elseif(3.5>$star && $star>=3){
            $star_str = '3.5';
        }elseif(3>$star && $star>=2.5){
            $star_str = '3';
        }elseif(2.5>$star && $star>=2){
            $star_str = '2.5';
        }elseif(2>$star && $star>=1.5){
            $star_str = '2';
        }elseif(1.5>$star && $star>=1){
            $star_str = '1.5';
        }elseif(1>$star && $star>=0.5){
            $star_str = '1';
        }elseif(0.5>$star){
            $star_str = '0.5';
        }
        return $star_str;
    }

    /**
     * @worker_level :护工等级
     */
    public function worker_level($level=3){
        if($level==1){
            $level_str = '中级';
        }elseif($level==2){
            $level_str = '高级';
        }elseif($level==3){
            $level_str = '特级';
        }
        return $level_str;
    }
}
