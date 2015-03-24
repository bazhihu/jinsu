<?php

namespace backend\Models;

use Yii;
use yii\web\HttpException;

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
     * 护工等级
     */
    const WORKER_LEVEL_MEDIUM = 1; //中级
    const WORKER_LEVEL_HIGH = 2; //高级
    const WORKER_LEVEL_SUPER = 3; //特级

    /**
     * 护工等级标签
     */
    static public $workerLevelLabel = [
        self::WORKER_LEVEL_MEDIUM => '中级',
        self::WORKER_LEVEL_HIGH   => '高级',
        self::WORKER_LEVEL_SUPER  => '特级'
    ];

    /**
     * 护工价格
     */
    static public $workerPrice = [
        self::WORKER_LEVEL_MEDIUM => 150,
        self::WORKER_LEVEL_HIGH   => 200,
        self::WORKER_LEVEL_SUPER  => 300
    ];


    /**
     * 文化程度
     */

    const EDUCATION_1 = 1; //文盲
    const EDUCATION_2 = 2; //小学
    const EDUCATION_3 = 3; //初中
    const EDUCATION_4 = 4; //高中
    const EDUCATION_5 = 5; //中技
    const EDUCATION_6 = 6; //中专
    const EDUCATION_7 = 7; //大专
    const EDUCATION_8 = 8; //本科
    const EDUCATION_9 = 9; //硕士
    const EDUCATION_10 = 10; //博士


    static public $educationLabel = [
        self::EDUCATION_1 => '文盲',
        self::EDUCATION_2 => '小学',
        self::EDUCATION_3 => '初中',
        self::EDUCATION_4 => '高中',
        self::EDUCATION_5 => '中技',
        self::EDUCATION_6 => '中专',
        self::EDUCATION_7 => '大专',
        self::EDUCATION_8 => '本科',
        self::EDUCATION_9 => '硕士',
        self::EDUCATION_10 => '博士',
    ];

    /**
     * 政治面貌politics
     */

    const POLITICS_1 = 1;
    const POLITICS_2 = 2;
    const POLITICS_3 = 3;
    const POLITICS_4 = 4;
    const POLITICS_5 = 5;
    const POLITICS_6 = 6;

    static public $politicsLabel = [
        self::POLITICS_1 => '群众',
        self::POLITICS_2 => '团员',
        self::POLITICS_3 => '中共党员',
        self::POLITICS_4 => '民主党派',
        self::POLITICS_5 => '无党派人士',
        self::POLITICS_6 => '其他'
    ];



    /**
     * 普通话水平chinese_level
     */

    const CHINESELEVEL_1 = 1;
    const CHINESELEVEL_2 = 2;
    const CHINESELEVEL_3 = 3;

    static public $chineselevelLabel = [
        self::CHINESELEVEL_1 => '一般',
        self::CHINESELEVEL_2 => '良好',
        self::CHINESELEVEL_3 => '熟练',
    ];


    /**
     *资质证书certificate  '1'=>'健康证','2'=>'护理证','3'=>'暂住证'
     */

    const CERTIFICATE_1 = 1;
    const CERTIFICATE_2 = 2;
    const CERTIFICATE_3 = 3;

    static public $certificateLabel = [
        self::CERTIFICATE_1 => '健康证',
        self::CERTIFICATE_2 => '护理证',
        self::CERTIFICATE_3 => '暂住证',
    ];

    static public  $nation = array (
        1=>'汉族',
        2=>'壮族',
        3=>'满族',
        4=>'回族',
        5=>'苗族',
        6=>'维吾尔族',
        7=>'土家族',
        8=>'彝族',
        9=>'蒙古族',
        10=>'藏族',
        11=>'布依族',
        12=>'侗族',
        13=>'瑶族',
        14=>'朝鲜族',
        15=>'白族',
        16=>'哈尼族',
        17=>'哈萨克族',
        18=>'黎族',
        19=>'傣族',
        20=>'畲族',
        21=>'傈僳族',
        22=>'仡佬族',
        23=>'东乡族',
        24=>'高山族',
        25=>'拉祜族',
        26=>'水族',
        27=>'佤族',
        28=>'纳西族',
        29=>'羌族',
        30=>'土族',
        31=>'仫佬族',
        32=>'锡伯族',
        33=>'柯尔克孜族',
        34=>'达斡尔族',
        35=>'景颇族',
        36=>'毛南族',
        37=>'撒拉族',
        38=>'布朗族',
        39=>'塔吉克族',
        40=>'阿昌族',
        41=>'普米族',
        42=>'鄂温克族',
        43=>'怒族',
        44=>'京族',
        45=>'基诺族',
        46=>'德昂族',
        47=>'保安族',
        48=>'俄罗斯族',
        49=>'裕固族',
        50=>'乌兹别克族',
        51=>'门巴族',
        52=>'鄂伦春族',
        53=>'独龙族',
        54=>'塔塔尔族',
        55=>'赫哲族',
        56=>'珞巴族'
    );

    public $birth_place_city;
    public $birth_place_area;



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
            [['name','idcard'], 'required'],
            [['gender'],'string', 'max' => 1],
            [['marriage', 'education', 'politics', 'chinese_level', 'adder', 'editer', 'total_score', 'star', 'total_order', 'total_comment', 'level', 'status'], 'integer'],
            [['birth', 'start_work', 'add_date', 'edit_date','hospital_id','office_id','good_at'], 'safe'],
            [['price', 'good_rate'], 'number'],
            [['name', 'birth_place','idcard','native_province', 'nation', 'phone1', 'phone2','certificate'], 'string', 'max' => 20],
            [['place'], 'string', 'max' => 255],

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
            'subcat_id' => '出生日期',
            'subsubcat' => '出生日期',
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
    public function workerAge($birth=''){
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
    public function workerStar($star=5){
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
     * 护工等级
     * @param null $level
     * @return array
     * @author zhangbo
     */
    static public function getWorkerLevel($level = null){
        return isset(self::$workerLevelLabel[$level]) ? self::$workerLevelLabel[$level] : self::$workerLevelLabel;
    }

    /**
     * 根据等级获取护工价格
     * @param int $level 护工等级
     * @return null|int
     * @author zhangbo
     */
    static public function getWorkerPrice($level){
        return isset(self::$workerPrice[$level]) ? self::$workerPrice[$level] : null;

    }
    /**
    * @param array $params
    * @return bool
    * @throws HttpException
    */
    public function createWorker($params){
        $params['add_date'] =date('Y-m-d H:i:s');
      //  $params['adder'] = $_SESSION['admin_uid'];

        $this->attributes = $params['Worker'];
        if(!$this->save()){
            throw new HttpException(400, print_r($this->getErrors(), true));
        }
        return true;
    }


    /**
     * 文化程度
     * @param null $level
     * @return array
     * @author tiancq
     */
    static public function getEducationLevel($education = null){
        return isset(self::$educationLabel[$education]) ? self::$educationLabel[$education] : self::$educationLabel;
    }


    /**
     * 政治面貌
     * @param null $level
     * @return array
     * @author tiancq
     */
    static public function getPoliticsLevel($politics = null){
        return isset(self::$politicsLabel[$politics]) ? self::$politicsLabel[$politics] : self::$politicsLabel;
    }


    /**
     * 普通话水平
     * @param null $chineselevel
     * @return array
     * @author tiancq
     */
    static public function getChineseLevel($chineselevel = null){
        return isset(self::$chineselevelLabel[$chineselevel]) ? self::$chineselevelLabel[$chineselevel] : self::$chineselevelLabel;
    }

    /**
     * 资质证书
     * @param null $chineselevel
     * @return array
     * @author tiancq
     */
    static public function getertificate($chineselevel = null){
        return isset(self::$certificateLabel[$chineselevel]) ? self::$certificateLabel[$chineselevel] : self::$certificateLabel;
    }

    /**
     * 资质证书
     * @param null $chineselevel
     * @return array
     * @author tiancq
     */
    static public function getCertificate($chineselevel = null){
        return isset(self::$certificateLabel[$chineselevel]) ? self::$certificateLabel[$chineselevel] : self::$certificateLabel;
    }





    /**
     * 民族
     * @param null $chineselevel
     * @return array
     * @author tiancq
     */
    static public function getNation($nationLevel=null){
       return isset(self::$nation[$nationLevel]) ? self::$nation[$nationLevel] : self::$nation;
    }
}