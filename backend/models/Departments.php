<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%departments}}".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%departments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * 获取科室列表
     * @param int $hospitalId 医院ID
     * @return static[]
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
                $list[$key] = $value;
                unset($items[$key]);

                if(empty($items)){
                    return false;
                }else{
                    self::formatItems($items, $level, $item['id'], $list);
                }
            }
        }

    }


}
