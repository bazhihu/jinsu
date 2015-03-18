<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="order-master-form">

    <?php
    $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_HORIZONTAL,
    ]);
    ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">用户信息</h3>
        </div>
        <div class="panel-body">
            <?php echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,

                'attributes' => [
                    'mobile'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入手机号...',
                            'maxlength'=>11,
                            'style'=>'width:25%'
                        ],
                    ],
                ]
            ]);?>
        </div>
    </div>

    <!--患者信息-->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">患者信息</h3>
        </div>
        <div class="panel-body">
            <?php echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'patients_name'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入姓名...',
                            'maxlength'=>4,
                            'style'=>'width:25%'
                        ],
                    ],
                    'patients_gender'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入性别...',
                            'maxlength'=>4,
                            'style'=>'width:25%'
                        ],
                    ],
                ]
            ]);?>
        </div>
    </div>

    <!--订单信息-->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">订单信息</h3>
        </div>
        <div class="panel-body">
            <?php echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributeDefaults'=>[
                    'type'=>Form::INPUT_TEXT,
                    'inputContainer'=>['class'=>'col-md-3'],
                    //'container'=>['class'=>'form-group'],
                ],
                'attributes' => [
                    'mobile'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入手机号...',
                            'maxlength'=>11,
                            'style'=>'width:25%'
                        ],
                    ],
                ]
            ]);?>
        </div>
    </div>

    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [


            'worker_level'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 护工等级...']],

            'start_time'=>[
                'type'=> Form::INPUT_WIDGET,
                'widgetClass'=>DateControl::classname(),
                'options'=>['type'=>DateControl::FORMAT_DATETIME]
            ],

            'end_time'=>[
                'type'=> Form::INPUT_WIDGET,
                'widgetClass'=>DateControl::classname(),
                'options'=>['type'=>DateControl::FORMAT_DATETIME]
            ],

            'patient_state'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 患者健康情况...']],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', '创建') : Yii::t('app', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
