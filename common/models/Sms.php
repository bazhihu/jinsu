<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/4
 * Time: 18:59
 */

namespace common\models;

use linslin\yii2\curl\Curl;
use Yii;
use yii\base\Model;

class Sms extends Model{

    public $mobile;

    const SMS_LOGIN_CODE                    = '1'; //登录时的验证码
    const SMS_ORDERS_NOT_PAID               = '2'; //订单未支付
    const SMS_ORDERS_SUCCESSFUL_PAYMENT     = '3'; //订单支付成功
    const SMS_ORDERS_OVER                   = '4'; //服务结束前24小时
    const SMS_ORDER_CANCELED                = '5'; //订单已取消
    const SMS_ORDERS_MODIFIED_SUCCESSFULLY  = '6'; //订单修改成功
    const SMS_ORDERS_COMPLETED              = '7'; //订单已完成
    const SMS_WITHDRAW_APPLICATION          = '8'; //提现申请
    const SMS_SUCCESS_RECHARGE              = '9'; //充值成功

    public static $hotLine = '400-12345678';//客服热线
    /**
     * 漫道科技序列号&密码
     * @var array
     */
    public static $manRoad = [
        'serialNo'  =>'SDK-BBX-010-22476',
        'pwd'       =>'b-__b3-4',
    ];
    /**
     * 三三得玖机构Id
     * @var array
     */
    public static $nine = [
        'agencyId'  => '68878',
        'username'  => 'admin',
        'pwd'       => '25340961',
    ];

    const SMS_SANSANDEJIU = 'http://GATEWAY.IEMS.NET.CN/GsmsHttp'; //三三得玖
    const SMS_MANDAOKEJI = 'http://sdk.entinfo.cn/webservice.asmx/mdSmsSend'; //漫道科技

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'required', 'message'=>'手机号码不能为空']
        ];
    }

    /**
     * 短信场景
     * @param $params
     * @return bool|string
     */
    public static function smsScene($params){
        #登录时的验证码
        if($params['type'] == self::SMS_LOGIN_CODE){
            if(!isset($params['code'])) return false;
            return '您的验证码为：'.$params['code'].'，请在5分钟内填写，如非本人操作请忽略本短信。';
        }
        #订单未支付
        if($params['type'] == self::SMS_ORDERS_NOT_PAID){
            if(!isset($params['time']) || !isset($params['level'])) return false;
            return '您预约的'.$params['time'].'开始的'.$params['level'].'级陪护服务订单还未支付，10分钟未支付订单将自动取消，请尽快完成支付。如有问题请联系我们~客服热线：'.self::$hotLine.'。';
        }
        #订单支付成功
        if($params['type'] == self::SMS_ORDERS_SUCCESSFUL_PAYMENT){
            if(!isset($params['time']) || !isset($params['level'])) return false;
            return '您预约的'.$params['time'].'开始的'.$params['level'].'级陪护服务已确认，服务人员将在指定时间到达提供服务。您可以在优爱医护App“我的订单”中查看追踪订单状态。如有问题请联系我们~客服热线：'.self::$hotLine.'。';
        }
        #服务结束前24小时
        if($params['type'] == self::SMS_ORDERS_OVER){
            if(!isset($params['time']) || !isset($params['level'])) return false;
            return '您的'.$params['level'].'级陪护服务将在'.$params['time'].'早上8:00即将结束，如您还需继续服务请在30分钟之内拨打客服热线：'.self::$hotLine.'进行续单，否则服务将在指定时间结束。';
        }
        #订单已取消
        if($params['type'] == self::SMS_ORDER_CANCELED){
            if(!isset($params['time']) || !isset($params['level'])) return false;
            return '您预约的'.$params['time'].'开始的'.$params['level'].'级陪护服务订单已取消，已支付金额会在3-10个工作日内退回您支付时的账号。如有问题请联系我们~客服热线：'.self::$hotLine.'，期待下次为您服务。';
        }
        #订单修改成功
        if($params['type'] == self::SMS_ORDERS_MODIFIED_SUCCESSFULLY){
            if(!isset($params['oldTime']) || !isset($params['oldLevel']) || !isset($params['newTime']) || !isset($params['newLevel']))
                return false;
            return '您预约的'.$params['oldTime'].'开始的'.$params['oldLevel'].'级陪护服务订单已成功修改为'.$params['newTime'].'开始的'.$params['newLevel'].'级陪护服务。您可以在优爱医护App“我的订单”中查看追踪订单状态。如有问题请联系我们~客服热线：'.self::$hotLine.'。';
        }
        #订单已完成
        if($params['type'] == self::SMS_ORDERS_COMPLETED){
            if(!isset($params['days']) || !isset($params['level'])) return false;
            return '您的'.$params['days'].'天'.$params['level'].'级陪护服务已完成，为了您以后享受更好的服务，请对我们的工作人员进行评价，感谢您的信任，祝您健康快乐~客服热线：'.self::$hotLine.'。';
        }
        #提现申请
        if($params['type'] == self::SMS_WITHDRAW_APPLICATION){
            if(!isset($params['money']) || !isset($params['account'])) return false;
            return '您有一笔'.$params['money'].'元的提现申请已确认，款项将在1-5个工作日内退回您指定的账号为：'.$params['account'].'的微信/支付宝账号，请注意查收。如有问题请联系我们~客服热线：'.self::$hotLine.'。';
        }
        #充值成功
        if($params['type'] == self::SMS_SUCCESS_RECHARGE){
            if(!isset($params['account']) || !isset($params['money']) || !isset($params['balance'])) return false;
            return '已成功为账号'.$params['account'].'充值'.$params['money'].'元，当前账号余额为：'.$params['balance'].'元。您可以在优爱医护App“我的钱包”中随时查看消费记录。如有问题请联系我们~客服热线：'.self::$hotLine.'。';
        }

        return false;
    }

    /**
     * 发送短信接口
     * @param $params
     * [
     *      'mobile'       电话号码     必
     *      'type'         场景类型     必
     *
     *      #type = SMS_LOGIN_CODE  登录时的验证码 1
     *      'code'         验证码
     *
     *      #type = SMS_ORDERS_NOT_PAID  订单未支付 2
     *      'time'         订单开始时间
     *      'level'        陪护等级
     *
     *      #type = SMS_ORDERS_SUCCESSFUL_PAYMENT  订单支付成功 3
     *      'time'         订单开始时间
     *      'level'        陪护等级
     *
     *      #type = SMS_ORDERS_OVER  服务结束前24小时 4
     *      'time'         订单结束时间
     *      'level'        陪护等级
     *
     *      #type = SMS_ORDER_CANCELED  订单已取消 5
     *      'time'         订单开始时间
     *      'level'        陪护等级
     *
     *      #type = SMS_ORDERS_MODIFIED_SUCCESSFULLY  订单修改成功 6
     *      'oldTime'         修改前订单时间
     *      'oldLevel'        修改前陪护等级
     *      'newTime'         订单时间
     *      'newLevel'        陪护等级
     *
     *      #type = SMS_ORDERS_COMPLETED  订单已完成 7
     *      'days'         订单持续天数
     *      'level'        陪护等级
     *
     *      #type = SMS_WITHDRAW_APPLICATION  提现申请 8
     *      'money'         提现金额
     *      'account'        提现帐号
     *
     *      #type = SMS_SUCCESS_RECHARGE  充值成功 9
     *      'account'         账户
     *      'money'           充值金额
     *      'balance'         余额
     *
     * ]
     * @return array
     * @author HZQ
     */
    public function send($params){

        $response = [
            'code'  => '200',
            'msg'   => '',
        ];

        $content    = self::smsScene($params);  //内容

        if(!$content)
        {
            $response['code'] =400;
            $response['msg'] ='参数错误';
        }

        $nine = self::_nineSend($params['mobile'],$content);
        if($nine['code'] != '200')
        {
            $manRoad = self::_manRoadSend($params['mobile'],$content);
            if($manRoad['code']!='200')
            {
                $response = [
                    'code'  => '400',
                    'msg'   => '发送短信失败',
                ];
                return $response;
            }
        }
        return $response;
    }

    /**
     * 漫道科技短信接口
     * @param $mobile
     * @param $content
     * @return array
     */
    protected static function _manRoadSend($mobile,$content){
        $curl = new Curl();

        $params = [
            'sn'=>self::$manRoad['serialNo'], ////替换成您自己的序列号
            'pwd'=>strtoupper(md5(self::$manRoad['serialNo'].self::$manRoad['pwd'])), //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
            'mobile'=>$mobile,//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content'=>iconv( "UTF-8", "GB2312//IGNORE" ,$content.'【优爱医护】'),//短信内容
            'ext'=>'',
            'stime'=>'',//定时时间 格式为2011-6-29 11:09:21
            'msgfmt'=>'',
            'rrid'=>''
        ];

        $curl->reset()
            ->setOption(
                CURLOPT_POSTFIELDS,
                http_build_query($params)
            )->post(Sms::SMS_MANDAOKEJI);
        $response = [
            'code'=>'200',
            'msg'=>'',
        ];
        if($curl->responseCode != '200'){
            $response['code'] = '404！';
            $response['msg'] = '发送失败！';
        }else{
            $response['msg'] = '发送短信成功！';
        }
        return $response;
    }

    /**
     * 三三得玖短信接口
     * @param $mobile
     * @param $content
     * @return array
     */
    protected static function _nineSend($mobile,$content){

        $curl = new Curl();

        $params = array(
            'username'=>self::$nine['agencyId'].':'.self::$nine['username'],
            'password'=>self::$nine['pwd'],
            'from'=>'18810987761',
            'to'=>$mobile,//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content'=>iconv( "UTF-8", "gbk//IGNORE" ,$content),//短信内容
            'presendTime'=>'',
        );
        $curl->reset()
            ->setOption(
                CURLOPT_POSTFIELDS,
                http_build_query($params)
            )->post(Sms::SMS_SANSANDEJIU);
        $response = [
            'code'=>'200',
            'msg'=>'',
        ];
        if($curl->responseCode != '200'){
            $response['code'] = '404！';
            $response['msg'] = '发送失败！';
        }else{
            $response['msg'] = '发送短信成功！';
        }
        return $response;
    }
}