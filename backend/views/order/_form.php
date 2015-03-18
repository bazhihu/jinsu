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
        'type'=>ActiveForm::TYPE_HORIZONTAL
    ]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'mobile'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'请输入手机号...', 'maxlength'=>11]],

            'worker_level'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 护工等级...']],

            'service_start_time'=>[
                'type'=> Form::INPUT_WIDGET,
                'widgetClass'=>DateControl::classname(),
                'options'=>['type'=>DateControl::FORMAT_DATETIME]
            ],

            'service_end_time'=>[
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
