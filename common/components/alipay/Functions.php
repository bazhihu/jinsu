<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/14
 * Time: 15:35
 */

namespace common\components\alipay;


class Functions {

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param array $params 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    public static function createLinkString($params) {
        $arg  = "";
        while (list ($key, $val) = each ($params)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){
            $arg = stripslashes($arg);
        }

        return $arg;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     * @param array $params 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    public static function createLinkStringUrlEncode($params) {
        $arg  = "";
        while (list ($key, $val) = each ($params)) {
            $arg.=$key."=".urlencode($val)."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){
            $arg = stripslashes($arg);
        }

        return $arg;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param array $params 签名参数组
     * @return array 去掉空值与签名参数后的新签名参数组
     */
    public static function paramFilter($params) {
        $paramsFilter = array();
        while (list ($key, $val) = each ($params)) {
            if($key == "sign" || $key == "sign_type" || $val == "")
                continue;
            else	
                $paramsFilter[$key] = $params[$key];
        }
        return $paramsFilter;
    }

    /**
     * 对数组排序
     * @param array $params 排序前的数组
     * @return mixed 排序后的数组
     */
    public static function argSort($params) {
        ksort($params);
        reset($params);
        return $params;
    }


    /**
     * 远程获取数据，POST模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * @param string $url 指定URL完整路径地址
     * @param string $cacert_url 指定当前工作目录绝对路径
     * @param array $params 请求的数据
     * @param string $inputCharset 编码格式。默认值：空值
     * @return string 远程输出的数据
     */
    public static function getHttpResponsePOST($url, $cacertUrl, $params, $inputCharset = '') {

        if (trim($inputCharset) != '') {
            $url = $url."_input_charset=".$inputCharset;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        curl_setopt($curl, CURLOPT_CAINFO,$cacertUrl);//证书地址
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl,CURLOPT_POST,true); // post传输数据
        curl_setopt($curl,CURLOPT_POSTFIELDS,$params);// post传输数据
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);

        return $responseText;
    }

    /**
     * 远程获取数据，GET模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * @param string $url 指定URL完整路径地址
     * @param string $cacertUrl 指定当前工作目录绝对路径
     * @return string 远程输出的数据
     */
    public static function getHttpResponseGET($url,$cacertUrl) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        curl_setopt($curl, CURLOPT_CAINFO,$cacertUrl);//证书地址
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);

        return $responseText;
    }

}