<?php

namespace backend\models;

use Yii;
use Yii\helpers\ArrayHelper;
use common\models\Redis;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $parent_id
 * @property string $zip
 * @property integer $group_id
 * @property string $wcode
 * @property integer $display
 * @property integer $continent_id
 */
class City extends \yii\db\ActiveRecord
{
    private static $_keyPrefix = 'city';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'type', 'parent_id', 'group_id', 'display', 'continent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 20],
            [['wcode'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编码',
            'type' => '区域类型',
            'name' => '地域名称',
            'parent_id' => '父亲编号',
            'zip' => '邮编',
            'group_id' => '所属地区',
            'wcode' => '天气',
            'display' => '状态',
            'continent_id' => '所属洲',
        ];
    }

    /**
     * 获取省份城市列表
     * @param int $parentId 省ID 市ID 区县ID
     * @param bool $display 是否启用显示隐藏城市功能
     * @param bool $format 是否格式化数组
     * @return static[]
     */
    static public function getList($parentId = null, $display = false, $format = true){
        $findArr = [];
        if($parentId != null){
            $findArr['parent_id'] = $parentId;
        }
        if($display){
            $findArr['display'] = 1;
        }
        if($format){
            $result = ArrayHelper::map(self::findAll($findArr), 'id', 'name');
        }else{
            $result = self::find()->select('id,name')->where($findArr)->asArray()->all();
        }

        //var_dump($result);
        return $result;
    }

    /**
     * 获取省份城市列表
     * @param int $parent_id 省ID 市ID 区县ID
     * @return static[]
     */
//    static public function getListPlace($parent_id = 1){
//        $findArr = ['parent_id' => $parent_id];
//        $data = self::find()->select('id,name')->where($findArr)->asArray()->all();
//        return $data;
//    }

    /**
     * 获取城市
     * @param $id
     * @return mixed|null|static
     */
    static public function getCity($id){
        $cacheKey = self::$_keyPrefix."/id:".$id;
        if(!$data = Redis::get($cacheKey)){
            $data = self::findOne($id);
            $data && Redis::set($cacheKey, $data);
        }

        return $data;
    }
    /**
     * 根据ID获取省份、城市、地区的NAME
     * @param int $IdStr 省ID 市ID 区县ID
     * @return static[]
     */
    static public function getCityName($IdStr){
        $data = null;
        $ids = explode(',', $IdStr);
        if(empty($ids)) return $data;

        foreach ($ids as $id) {
            $result = self::getCity($id);
            $data .= $result['name']." ";
        }
        return $data;
    }

    /**
     * 删除缓存
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $keys = Redis::keys(self::$_keyPrefix.'/*');
        Redis::del($keys);
    }

    /**
     * 删除缓存
     */
    public function afterDelete(){
        parent::afterDelete();
        $keys = Redis::keys(self::$_keyPrefix.'/*');
        Redis::del($keys);
    }
}
