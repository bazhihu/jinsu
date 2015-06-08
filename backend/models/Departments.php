<?php

namespace backend\models;

use Yii;
use common\models\Redis;

/**
 * This is the model class for table "{{%departments}}".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 */
class Departments extends \yii\db\ActiveRecord
{
    private static $_keyPrefix = 'departments';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%departments}}';
    }

    /**
     * 获取科室列表
     * @param int $hospitalId 医院ID
     * @return static[]
     * @author zhangbo
     */
    static public function getList($hospitalId = null){
        $result = array();
        if(empty($hospitalId)){
            $result = self::find()->all();
        }else{
            //通过医院选择科室@TODO...
        }
        if(empty($result)){
            return $result;
        }

        $list = array();
        self::formatItems($result, 0, 0, $list);

        return $list;
    }

    /**
     * 格式化成树形格式数据
     * @param array $items 数据项
     * @param int $level 层级
     * @param int $parentId 父级ID
     * @param array $list 最终格式化的结果
     * @return bool
     * @author zhangbo
     */
    static public function formatItems($items, $level, $parentId, &$list){
        $level += 1;
        $tree = str_repeat('--', $level);
        foreach ($items as $key => $item) {
            if($item['parent_id'] == $parentId){
                if($level > 1){
                    $value = '|'.$tree.$item['name'];
                }else{
                    $value = $item['name'];
                }
                $list[$item['id']] = $value;
                unset($items[$key]);

                if(empty($items)){
                    return false;
                }else{
                    self::formatItems($items, $level, $item['id'], $list);
                }
            }
        }
    }

    static public function getParent(){
        $list = array('0'=>'选择');
        $result = self::findAll(['parent_id'=>'0']);

        foreach($result as $key=>$val){
            $list[$val['id']]=$val['name'];
        }
        return $list;
    }

    /**
     * 根据ID获取科室的NAME
     * @param string $IdStr
     * @return null|string
     */
    static public function getDepartmentNames($IdStr){
        $data = null;
        $ids = explode(',', $IdStr);
        if(empty($ids)) return null;

        $result = [];
        foreach ($ids as $id) {
            if($id){
                $result[] = self::getName($id);
            }
        }
        $data .= implode('、', $result);

        return $data;
    }

    /**
     * 获取科室名称
     * @param int $id
     * @return string
     * @author zhangbo
     */
    static function getName($id){
        $cacheKey = self::$_keyPrefix."/id:".$id;
        if(!$data = Redis::get($cacheKey)){
            $data = self::findOne($id);
            $data && Redis::set($cacheKey, $data);
        }

        return $data['name'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '科室名称',
            'parent_id' => '父亲科室',
            'pinyin'=>'拼音'
        ];
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
