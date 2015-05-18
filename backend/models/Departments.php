<?php

namespace backend\models;

use Yii;

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
        ];
    }

    /**
     * 获取科室名称
     * @param int $id
     * @return string
     * @author zhangbo
     */
    static public function getName($id){
        return self::findOne($id)->name;
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
    static public function getDepartmentName($IdStr){
        $data = null;
        $ids = explode(',', $IdStr);
        if(empty($ids)) return null;

        $result = [];
        foreach ($ids as $id) {
            if($id){
                $findArr = ['id' => $id];
                $result[] = self::findOne($findArr)['name'];
            }
        }
        $data .= implode('、',$result);


        return $data;
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
}
