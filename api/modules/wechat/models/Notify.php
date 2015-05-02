<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 17:30
 */

namespace api\modules\wechat\models;

use Yii;
use common\components\wechat;
use common\components\wechat\Common_util_pub;
use common\components\wechat\JsApi_pub;

class Notify{

    function getCode(){
        //使用jsapi接口

        $jsApi = new JsApi_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code']))
        {
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']);
            Header("Location: $url");
        }else
        {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }
    }
}