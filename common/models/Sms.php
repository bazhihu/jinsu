<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/4
 * Time: 18:59
 */

namespace common\models;

use Yii;
use yii\base\Model;
use common\components\Curl;

class Sms extends Model{

    public $mobile;

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
     * 发送短信验证码
     * @param $mobile
     * @param $code
     * @return array
     * @author zhangbo mod huzhiqiang
     */
    public function send($mobile,$code){

        $content    = '不能告诉任何人的短信验证码为:'.$code.'验证码10分钟内有效';  //内容

        $response = [
            'code'  => '200',
            'msg'   => '',
        ];

        $nine = self::nineSend($mobile,$content);
        if($nine['code'] != '200')
        {
            $manRoad = self::manRoadSend($mobile,$content);
            if($manRoad['code']!='200')
            {
                $response = [
                    'code'  => '404',
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
    protected function manRoadSend($mobile,$content){

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
    protected function nineSend($mobile,$content){

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