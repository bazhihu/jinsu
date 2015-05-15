<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 17:30
 */

namespace api\modules\wechat\models;

use backend\models\WalletUserDetail;
use common\models\Order;
use common\models\Wallet;
use common\models\WechatLog;
use Yii;
use common\components\wechat;
use common\components\wechat\WxpayServerPub;

class Notify{
    function notifyUrl(){
        $notify = new wechat\PayNotifyCallBack();

        $notify->Handle(false);
    }
}