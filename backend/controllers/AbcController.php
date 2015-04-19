<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/9
 * Time: 18:33
 */
namespace backend\controllers;


use common\models\Sms;
use common\models\UmengPush;
use Yii;
use yii\web\Controller;

/**
 * WalletUserDetailController implements the CRUD actions for WalletUserDetail model.
 */
class AbcController extends Controller
{

    public function actionSend(){


        echo urlencode('mxHWBmEFEqi7A6dTpVCrZzVmMGYyZDI0ZDU5ZDIwZWMzMjdmYTk0MWU4MmFjMmE2MzJlZjBmNTE1Mzg0N2YwMTUwNDEyNGE5MzRjOGU2MTLvO+we20rwSxm/f24MjjDCdvs04yZxwUBd5nwWtaviBLrRb9LqSDOLoudfyP6985TfyopEsziiuT43sgziHhx7');
        exit;
        echo urlencode('1gbcBOR9qz5K2J8+4f9+aTkwZjFmOGVjMjQ3NTlkNGY3YmQ5YjI0NmM5NTBkMjNhMzc2MTZhNGU3NWYwYTUyNzI4NGYzNWMxNzk4MjM1NTiAo2cMh4x7QzL16uFgEUeEJnqTU2AqXde8VchtDIj3TCi17SzS4t+YmT/mwEAOX/oLqXjiukA9mlLh4uXoZr7B');
        exit;
        $sms = new Sms();

        /*$string = '2015-04-14 00:00:00';

        $var = date('Y年m月d日',time($string));
        var_dump($var);exit;*/

        //$res = $sms->send('18810987761','154785');
        $params = [
            //'mobile'=>'18810987761,13911037234,18610308130,18942674005,17600819859',
            'mobile'=>'15319043556',
            'account'=>'13911037234',
            'type'=>Sms::SMS_LOGIN_CODE,
            'code'=>'158751',
            'time'=>date('m月d日',time('2015-04-08 00:00:00')),
            'level'=>'高级',
            'hospital'=>'天坛医院',
            'days'=>'3',
            'money'=>'10000',
            'balance'=>'10000',
        ];
        $res = $sms->send($params);
        var_dump($res);
    }

    public function actionPush(){

        $push = new UmengPush();
        $res = $push->AndroidPush('测试中');
    }

    public function actionGet(){
        return var_dump($_REQUEST);
    }
}
