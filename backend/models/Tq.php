<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;


class Tq extends Model
{
    public function load_TQ($data)
    {
        if (!empty($data)) {
            $this->setAttributes($data);
            return true;
        } else {
            return false;
        }
    }

}