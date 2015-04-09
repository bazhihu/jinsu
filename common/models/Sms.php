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

class Sms extends Model{

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

    public $mobile;

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

        $flag = 0;
        //要post的数据
        $argv = array(
            'sn'=>self::$manRoad['serialNo'], ////替换成您自己的序列号
            'pwd'=>strtoupper(md5(self::$manRoad['serialNo'].self::$manRoad['pwd'])), //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
            'mobile'=>$mobile,//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            //'content'=>iconv( "GB2312", "UTF-8//IGNORE" ,$content),//短信内容
            'content'=>$content.'【优爱医护】',//短信内容
            'ext'=>'',
            'stime'=>'',//定时时间 格式为2011-6-29 11:09:21
            'msgfmt'=>'',
            'rrid'=>''
        );
        $params = '';
        //构造要post的字符串
        foreach ($argv as $key=>$value) {
            if ($flag!=0) {
                $params .= "&";
                $flag = 1;
            }
            $params.= $key."="; $params.= urlencode($value);
            $flag = 1;
        }
        $length = strlen($params);
        //创建socket连接
        $fp = fsockopen("sdk.entinfo.cn",8061,$errno,$errstr,10) or exit($errstr."--->".$errno);
        //构造post请求的头
        $header = "POST /webservice.asmx/mdsmssend HTTP/1.1\r\n";
        $header .= "Host:sdk.entinfo.cn\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        //添加post的字符串
        $header .= $params."\r\n";
        //发送post的数据
        fputs($fp,$header);
        $inheader = 1;
        while (!feof($fp)) {
            $line = fgets($fp); //去除请求包的头只显示页面的返回数据

            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            }
        }
        //<string xmlns="http://tempuri.org/">-5</string>
        $line=str_replace("<string xmlns=\"http://tempuri.org/\">","",$line);
        $line=str_replace("</string>","",$line);
        $result=explode("-",$line);
        // echo $line."-------------";
        $response = [
            'code'=>'200',
            'msg'=>'',
        ];
        if(count($result)>1){
            $response['code'] = '404！';
            $response['msg'] = '发送失败！';
            return $response;
        }else{
            $response['msg'] = '发送短信成功！';
            return $response;
        }
    }

    /**
     * 三三得玖短信接口
     * @param $mobile
     * @param $content
     * @return array
     */
    protected function nineSend($mobile,$content){
        $flag = 0;
        //要post的数据
        $argv = array(
            'username'=>self::$nine['agencyId'].':'.self::$nine['username'],
            'password'=>self::$nine['pwd'],
            'from'=>'18810987761',
            'to'=>$mobile,//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content'=>iconv( "UTF-8", "gbk//IGNORE" ,$content),//短信内容
            'presendTime'=>'',
        );
        $params = '';
        //构造要post的字符串
        foreach ($argv as $key=>$value) {
            if ($flag!=0) {
                $params .= "&";
                $flag = 1;
            }
            $params.= $key."="; $params.= urlencode($value);
            $flag = 1;
        }
        $length = strlen($params);
        //创建socket连接
        $fp = fsockopen("GATEWAY.IEMS.NET.CN",80,$errno,$errstr,10) or exit($errstr."--->".$errno);
        //构造post请求的头
        $header = "POST /GsmsHttp HTTP/1.1\r\n";
        $header .= "Host:GATEWAY.IEMS.NET.CN\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        //添加post的字符串
        $header .= $params."\r\n";
        //发送post的数据
        fputs($fp,$header);
        $inheader = 1;
        while (!feof($fp)) {
            $line = fgets($fp); //去除请求包的头只显示页面的返回数据

            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            }
        }
        //<string xmlns="http://tempuri.org/">-5</string>
        $line=str_replace("<string xmlns=\"http://tempuri.org/\">","",$line);
        $line=str_replace("</string>","",$line);
        $result=explode("-",$line);
        // echo $line."-------------";
        $response = [
            'code'=>'200',
            'msg'=>'',
        ];
        if(count($result)>1){
            $response['code'] = '404！';
            $response['msg'] = '发送失败！';
            return $response;
        }else{
            $response['msg'] = '发送短信成功！';
            return $response;
        }
    }
}