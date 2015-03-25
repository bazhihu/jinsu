<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Holidays $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="holidays-form" >
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">添加节假日日期</h3>
        </div>
        <div class="panel-body" style="margin: 100px 0 100px">
        <?php
        $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
        echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'date' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'autoWidget' => false,
                'options' => [
                    'options'=>[
                        'options'=>['placeholder'=>'请选择节假日日期...','style'=>'width:19%']
                    ],
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'type' => DateControl::FORMAT_DATE
                ]
            ],

        ]


        ]);
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', '添加') : Yii::t('app', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        ActiveForm::end(); ?>
        </div>
    </div>

</div>
