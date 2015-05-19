<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
@define("WEB_ROOT", "/www/youaiyihu.com/");
require_once WEB_ROOT."/common/components/wxpay/lib/WxPay.Api.php";
require_once WEB_ROOT."/common/components/wxpay/lib/WxPay.Notify.php";
require_once WEB_ROOT."/common/components/wxpay/unit/log.php";

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function NotifyProcess($data, &$msg)
    {
        //Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }


        //Log::DEBUG("PostYayhApi Start");
        $input_xml=file_get_contents("php://input");
        Log::DEBUG("PostYayhXML : " . $input_xml);
        self::PostYayhApi($input_xml);


        return true;
    }

    //重写回调处理函数

    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        //Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }
    //发送请求

    public function PostYayhApi($data){
        //Log::DEBUG("PostYayhApi Starting...");
        $url="http://api.youaiyihu.com/wechat/notify";
        if($_SERVER["HTTP_HOST"] !="m.youaiyihu.com"){
            $url="http://uat.api.youaiyihu.com/wechat/notify";
        }
        $info=self::postXmlCurl($data, $url);
        Log::DEBUG("PostYayhApi:" . json_encode($info));
        //Log::DEBUG("PostYayhApi End");
    }
    private static  function postXmlCurl($xml, $url, $second = 30)
    {
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);

        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            //throw new WxPayException("curl出错，错误码:$error");
            Log::DEBUG("curl出错，错误码:$error");
        }
    }

}

Log::DEBUG("begin notify");
//Log::DEBUG("page info:" . json_encode($_REQUEST));
$notify = new PayNotifyCallBack();
$notify->Handle(false);
