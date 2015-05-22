<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/9
 * Time: 18:33
 */
namespace backend\controllers;


use backend\models\Worker;
use common\models\Sms;
use common\models\UmengPush;
use common\models\Wallet;
use Yii;
use yii\web\Controller;

/**
 * WalletUserDetailController implements the CRUD actions for WalletUserDetail model.
 */
class AbcController extends Controller
{

    public function actionSend(){

        var_dump($_SERVER["HTTP_HOST"]);exit;
/*        echo urlencode('http://uat.api.youaiyihu.com/wechat/notify');
exit;*/
        /*echo urlencode('mxHWBmEFEqi7A6dTpVCrZzVmMGYyZDI0ZDU5ZDIwZWMzMjdmYTk0MWU4MmFjMmE2MzJlZjBmNTE1Mzg0N2YwMTUwNDEyNGE5MzRjOGU2MTLvO+we20rwSxm/f24MjjDCdvs04yZxwUBd5nwWtaviBLrRb9LqSDOLoudfyP6985TfyopEsziiuT43sgziHhx7');
        exit;
        echo urlencode('hS0v+spF59eVO0GGTaklBTFjYTZkMWYyMjM3MWFjNzA3ZDYzM2I4MWFjNTAwYmM0YTQ2NmZlM2VjZTkwNGRiNjM2MTUyOWNlNmQwYzM4NDKAGR77LfCv+dTgvp98F8FFbPoyOiyxO5PMVJg3RWdWBMedbgfB5SYsUldqETxtueQey4y80tG0h38gsi8FB6sL');
        exit;*/

       /* $res = Wallet::getBalance(30);
        var_dump($res);exit;*/

        /*$res = Wallet::getBalance(35);
        var_dump($res);
        exit;

        $sms = new Sms();*/

        /*$string = '2015-04-14 00:00:00';

        $var = date('Y年m月d日',time($string));
        var_dump($var);exit;*/

        //$res = $sms->send('18810987761','154785');
        /*$params = [
            //'mobile'=>'18810987761,13911037234,18610308130,18942674005,17600819859',
            'mobile'=>'18810987761',
            'account'=>'13911037234',
            'type'=>Sms::SMS_SUCCESS_RECHARGE,
            'code'=>'158751',
            'time'=>date('m月d日',time('2015-04-08 00:00:00')),
            'level'=>'高级',
            'hospital'=>'天坛医院',
            'days'=>'3',
            'money'=>'10000',
            'balance'=>'10000',
        ];
        $res = $sms->send($params);
        var_dump($res);*/
    }

    /**
     * 护工头像判断
     */
    public function actionCarer(){
        $carer = new Worker();
        $all = $carer::find()->all();
        foreach($all as $key=>$val){
            $picId = $val->worker_id;
            $picPath = 'uploads/'.$picId.'.jpg';
            if(file_exists($picPath)){
                $val->pic = $picId;
            }else{
                $val->pic = '';
            }
            $val->save();
        }
    }
    public function actionPush(){

        $push = new UmengPush();
        $res = $push->AndroidPush('测试中');
    }

    public function actionGet(){
        return var_dump($_REQUEST);
    }
}
