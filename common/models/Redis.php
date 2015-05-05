<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/27
 * Time: 17:45
 */

namespace common\models;


class Redis {
    public static $redis = 'redis';

    public function __construct(){
        $this->redis = \Yii::$app->get($this->redis);
    }
    public static function redis(){
        return \Yii::$app->get(self::$redis);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public static function set($key, $value){
        $value = serialize($value);
        return self::redis()->executeCommand('SET', [$key, $value]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get($key){
        $value = self::redis()->executeCommand('GET', [$key]);
        return unserialize($value);
    }

    /**
     * @param string $pattern
     * @return array
     */
    public static function keys($pattern){
        return self::redis()->executeCommand('KEYS', [$pattern]);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function del($key){
        $keys = [];
        if(is_array($key)){
            foreach($key as $k){
                $keys[] = $k;
            }
        }else{
            $keys[] = $key;
        }
        return self::redis()->executeCommand('DEL', $keys);
    }
}