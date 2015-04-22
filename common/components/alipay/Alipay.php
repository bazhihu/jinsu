<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/15
 * Time: 16:32
 */

namespace common\components\alipay;

use Yii;

class Alipay {

    public static $notifyUrl;
    private $_config = null;

    public function __construct(){
        $this->_config = Yii::$app->params['aliPay'];
        self::$notifyUrl = 'http://'.Yii::$app->getRequest()->serverName.'/alipay/notify';
    }
}