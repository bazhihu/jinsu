<?php
namespace common\components\wechat;

use Yii;
use yii\base\Exception;
/**
 *
 * 接口调用结果类
 * @author widyhu
 *
 */
class WxPayResults extends WxPayDataBase
{
    /**
     *
     * 使用数组初始化对象
     * @param array $array
     * @param 是否检测签名 $noCheckSign
     */
    public static function InitFromArray($array, $noCheckSign = false)
    {
        $obj = new self();
        $obj->FromArray($array);
        if($noCheckSign == false){
            $obj->CheckSign();
        }
        return $obj;
    }

    /**
     *
     * 使用数组初始化
     * @param array $array
     */
    public function FromArray($array)
    {
        $this->values = $array;
    }

    /**
     *
     * 检测签名
     */
    public function CheckSign()
    {
        if(!$this->IsSignSet()){
            return true;
        }
        $sign = $this->MakeSign();
        if($this->GetSign() == $sign){
            return true;
        }
        throw new Exception("签名错误！");
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @throws Exception
     */
    public static function Init($xml)
    {
        $obj = new self();
        $obj->FromXml($xml);
        $obj->CheckSign();
        return $obj->GetValues();
    }
}