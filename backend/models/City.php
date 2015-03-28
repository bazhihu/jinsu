<?php

namespace backend\models;

use Yii;
use Yii\helpers\ArrayHelper;

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
     * @param int $parent_id 省ID 市ID 区县ID
     * @return static[]
     */
     static public function getList($parent_id = 1){
        $findArr = ['parent_id' => $parent_id];
        $result =ArrayHelper::map(self::findAll($findArr), 'id', 'name');
        //var_dump($result);
        return $result;
    }

    /**
     * 获取省份城市列表
     * @param int $parent_id 省ID 市ID 区县ID
     * @return static[]
     */
    static public function getListPlace($parent_id = 1){
        $findArr = ['parent_id' => $parent_id];
        $result = self::findAll($findArr);

        $data = array();
        foreach($result as $key=>$value) {
            $data[] = array(
                'id' => $value['id'],
                'name' => $value['name']
            );
        }
        return $data;
    }
    /**
     * 根据ID获取省份、城市、地区的NAME
     * @param int $IdStr 省ID 市ID 区县ID
     * @return static[]
     */

    static public  function  getCityName($IdStr=''){
        $data = null;
        if($IdStr){
            $ids = explode(',',$IdStr);
            if($ids) {
                foreach ($ids as $id) {
                    $findArr = ['id' => $id];
                    $result = self::findOne($findArr);

                    $data .= $result['name']." ";
                }
            }
        }
        return $data;
    }
}
