<?php

namespace backend\models\dictionary;

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
            'parent_id' => '父亲科室',
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
    static public function getParent(){
        $list = array('0'=>'选择');
        $result = self::findAll(['parent_id'=>'0']);

        foreach($result as $key=>$val){
            $list[$val['id']]=$val['name'];
        }
        return $list;
    }
    /**
     * 根据ID获取医院的NAME
     * @param int $IdStr
     * @return static[]
     */

    static public  function  getDepartmentName($IdStr=''){
        $ids = explode(',',$IdStr);
        $data = null;
        if($ids) {
            foreach ($ids as $id) {
                $findArr = ['id' => $id];
                $result = self::findOne($findArr);

                $data .= $result->name." ";
            }
        }
        return $data;
    }


    /**
     * 格式化成树形格式数据
     * @param array $items 数据项
     * @param int $level 层级
     * @param int $parentId 父级ID
     * @param array $list 最终格式化的结果
     * @return bool
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
