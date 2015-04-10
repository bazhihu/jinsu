<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/10
 * Time: 17:36
 */
namespace common\models;

use Yii;
use yii\base\Model;
use common\components\Curl;

class UmengPush extends Model{

    public static $sendLine = 'http://msg.umeng.com/api/send';

    /*public static $msgPush = [
        'appKey_android'=>'55273853fd98c55a9f000c68',
        'app_master_secret_android'=>'efcf1xruoiqo4blyiajxho8tpgvhwzhl',
    ];*/

    public static $msgPushKey = [
        'appKey_android'=>'5472b857fd98c5ec3b000655',
        'app_master_secret_android'=>'g7a2l4mdxqd1aey81wniwokxmxmihihd',
    ];

    /**
     * 安卓消息推送
     * @param $text 推送内容
     * @param int $alias 推送用户（手机号）
     */
    public static function AndroidPush($text,$alias=687671)
    {
        $method = 'POST';

        $curl = new Curl();

        $params = [
            'appkey'=>self::$msgPushKey['appKey_android'],
            'timestamp'=>time(),
            'device_tokens'=>self::$msgPushKey['appKey_android'],
            'type'=>'customizedcast',
            'alias'=>$alias,
            'alias_type'=>'self',
            'payload'=>[
                'display_type'=>'notification',
                'body'=>[
                    'ticker'=>'优爱医护',
                    'title'=>'优爱医护',
                    'text'=>$text,
                    'after_open'=>'go_custom',
                ],
            ],
        ];
        $params = json_encode($params);
        $sign = MD5($method.self::$sendLine.$params.self::$msgPushKey['app_master_secret_android']);

        $curl->reset()
            ->setOption(
                CURLOPT_POSTFIELDS,
                $params
            )->post(self::$sendLine.'?sign='.$sign);
        $response = [
            'code'=>'200',
            'msg'=>''
        ];
        if($curl->responseCode=='200')
        {
            $response['msg'] = '短信发送成功';
        }else{
            $response = [
                'code'=>'400',
                'msg'=>'短信发送失败'
            ];
        }
        return $response;
    }
}