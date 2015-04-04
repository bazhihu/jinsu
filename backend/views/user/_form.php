<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$this->title?></h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'mobile'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入手机号...',
                            'maxlength'=>32,
                            'style'=>'width:50%'
                        ]
                    ],

                    'name'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入姓名...',
                            'maxlength'=>50,
                            'style'=>'width:50%'
                        ]
                    ],

                    'gender'=>[
                        'type'=> Form::INPUT_RADIO_LIST,
                        'options'=>['placeholder'=>'请选择性别...'], 'items'=>['男'=>'男','女'=>'女'], 'options'=>['inline'=>true]
                    ],
                ]
            ]);
            if(!$model->isNewRecord){
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'status'=>[
                            'type'=> Form::INPUT_RADIO_LIST,
                            'options'=>['placeholder'=>'请选择账号状态...'], 'items'=>['1'=>'正常','2'=>'禁用'], 'options'=>['inline'=>true]
                        ],
                    ]
                ]);
            }
            //echo $form->field($model, 'pic')->inputOptions('IN'); ;
            echo Html::submitButton($model->isNewRecord ? Yii::t('app', '注册') : Yii::t('app', '编辑'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);?>
        </div>
    </div>
    <? ActiveForm::end(); ?>
</div>