<?php

namespace backend\models;

use common\models\Sms;
use common\models\Wallet;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%wallet_withdrawcash}}".
 *
 * @property integer $withdrawcash_id
 * @property string $withdrawcash_no
 * @property integer $uid
 * @property string $money
 * @property integer $status
 * @property string $remark_audit
 * @property string $remark_apply
 * @property integer $payee_type
 * @property string $payee_time
 * @property string $payee_hospital
 * @property string $payee_name
 * @property string $payee_id_card
 * @property string $time_apply
 * @property string $time_audit
 * @property string $time_payment
 * @property integer $admin_uid_payment
 * @property integer $admin_uid_audit
 * @property integer $admin_uid_apply
 */
class WalletWithdrawcash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_withdrawcash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'uid',
                    'money',
                    'payee_type',
                    'payee_time',
                    'payee_hospital',
                    'payee_name',
                    'payee_id_card',
                ],
                'required',
                'on'=>['applyCash']
            ],
            [
                'payee_id_card','match','pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/',
            ],

            [['uid', 'status', 'payee_type', 'admin_uid_payment', 'admin_uid_audit', 'admin_uid_apply'], 'integer'],
            [['money'], 'number'],
            [['payee_time', 'time_apply', 'time_audit', 'time_payment'], 'safe'],
            [['withdrawcash_no', 'payee_name', 'payee_id_card'], 'string', 'max' => 50],
            [['remark_audit', 'remark_apply', 'payee_hospital'], 'string', 'max' => 255]
        ];
    }

    /**
     * 定义场景
     * @return array
     */
    public function scenarios()
    {
        return[
            'applyCash'=>['uid','money','payee_type','payee_time','payee_hospital','payee_name','payee_id_card',],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'withdrawcash_id' => '提现记录ID',
            'withdrawcash_no' => '提现记录编号',
            'uid' => '用户ID',
            'mobile' => '用户帐号',
            'money' => '提现金额',
            'status' => '状态',
            'remark_audit' => '审核备注',
            'remark_apply' => '申请备注',
            'payee_type' => '收款方式',
            'payee_time' => '收款时间',
            'payee_hospital' => '取款医院',
            'payee_name' => '收款人姓名',
            'payee_id_card' => '收款人身份证',
            'time_apply' => '提现申请时间',
            'time_audit' => '提现审核时间',
            'time_payment' => '提现付款时间',
            'admin_uid_payment' => '付款管理员',
            'admin_uid_audit' => '审核管理员',
            'admin_uid_apply' => '申请管理员',
        ];
    }

    /**
     * 申请取款
     * @return bool
     */
    public function create(){

        if($this->payee_time<date('Y-m-d')){
            $this->addError('payee_time','取款时间错误！');
            return false;
        }
        if($this->money<=0){
            $this->addError('payee_type','取款金额不符合要求！');
            return false;
        }
        #补充必要操作记录
        $params = [
            'status'            =>0,
            'mobile'            =>User::findOne(['id'=>$this->uid])->mobile,
            'withdrawcash_no'   =>self::_generateWalletNo(),
            'time_apply'        =>date('Y-m-d H:i:s'),
            'admin_uid_apply'   =>\Yii::$app->user->getId(),
        ];
        $this->setAttributes($params,false);
        if(!$this->save())
        {
            return false;
        }
        return true;
    }
    /**
     * 更改申请的状态
     * @param $params
     * [
     *      'id'    =>'withdrawcash_id', //提现记录ID
     *      'to do'  =>'to do',           //同意拒绝
     * ]
     * @return bool
     */
    public function check($params){
        $update = [
            'time_audit'=>date('Y-m-d H:i:s'),
            'admin_uid_audit'=>$params['admin_uid'],
        ];

        if($params['todo']){
            $update['status'] =2;
            if($this->updateAll($update,['withdrawcash_id'=>$params['id']])){
                $cash = $this->findOne(['withdrawcash_id'=>$params['id']]);
                #发送短信
                $sms = new Sms();
                $send = [
                    'mobile'    =>$cash->mobile,
                    'type'      =>Sms::SMS_WITHDRAW_APPLICATION,
                    'money'     =>$cash->money,
                    'time'      =>date('Y年m月d日',time($cash->payee_time)),
                    'hospital'  =>Hospitals::getName($cash->payee_hospital),
                ];
                $return = $sms->send($send);
                return true;
            }
        }else{
            $update['status'] =1;
            $update['remark_audit'] = isset($params['reason'])?$params['reason']:'';
            if($this->updateAll($update,['withdrawcash_id'=>$params['id']])){
                return true;
            }
        }
        return false;
    }

    /**
     * 用户钱包状态
     * @var array
     */
    public static $status = [
        '0'  =>  '申请提现中待审核',
        '1'  =>  '申请提现已拒绝',
        '2'  =>  '审核通过',
        '3'  =>  '已提现成功',
    ];

    /**
     * 获取用户的钱包状态
     * @param null $uid 用户ID
     * @return array|null
     */
    public static function getWalletStatusByUid($uid=null)
    {
        $response = [
            'code'  => 200,
            'msg'   => '',
        ];

        if($uid == null)
        {
            return null;
        }else{
            $status = self::find()->andFilterWhere(['uid'=>$uid])
                ->addOrderBy(['withdrawcash_id' => SORT_DESC])
                ->one();
            if(!$status)
            {
                $response['msg'] = '正常';
                return $response;
            }else{
                $response = [
                    'code'  => $status['status'],
                    'msg'   => self::$status[$status['status']],
                ];
                return $response;
            }
        }
    }

    /**
     * 提现付款操作
     * @param $id 提现记录ID
     * @return bool
     */
    public function pay($id){
        #事务-START
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $withdrawcash = $this->findOne(['withdrawcash_id'=>$id]);

            #修改提现记录
            if(!$this->payMoney($id)){
                return false;
            }

            #账户清零
            $walletUser = new WalletUser();
            if(!$walletUser->purseCleared($withdrawcash->uid)){
                return false;
            }
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            throw new HttpException(400, print_r($e, true));
        }
        #事务-END
        return true;
    }

    /**
     * 去付钱给用户
     * @param $id 提现记录ID
     * @return bool
     */
    public function payMoney($id){
        $update = [
            'time_payment'=>date('Y-m-d H:i:s'),
            'admin_uid_payment'=>Yii::$app->user->identity->getId(),
            'status'=>3,
        ];
        if(!$this->updateAll($update,['withdrawcash_id'=>$id])){
            return false;
        }
        return true;
    }
    /**
     * 生成钱包流水号
     * @return string
     * @throws \Exception
     * @author HZQ
     */
    private function _generateWalletNo(){
        $walletIncrement = new WalletIncrement();
        $walletIncrement->insert();
        return date("Ymd").$walletIncrement->id.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }
}
