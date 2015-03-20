<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

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

            <?php

            echo Form::widget([
                'model' => $orderPatientModel,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'name'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入姓名...',
                            'maxlength'=>4,
                            'style'=>'width:25%'
                        ],
                    ],
                    'gender'=>[
                        'type'=> Form::INPUT_RADIO_LIST,
                        'items'=>['1'=>'男','2'=>'女'],
                        'options'=>[
                            'inline'=>true
                        ]
                    ],
                    'age'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'请输入年龄...',
                            'maxlength'=>3,
                            'style'=>'width:25%'
                        ],
                    ],
                ]
            ]);

            echo $form->field($orderPatientModel, 'height', [
                'addon' => ['append' => ['content'=>'cm'],'groupOptions'=>['class'=>'col-md-3']]
            ]);
            echo $form->field($orderPatientModel, 'weight', [
                'addon' => ['append' => ['content'=>'kg'],'groupOptions'=>['class'=>'col-md-3']]
            ]);
            echo $form->field($orderPatientModel, 'patient_state')
                ->radioList(
                    ['0'=>'不能自理','1'=>'能自理'],
                    ['inline'=>true]
                );
            echo $form->field($orderPatientModel, 'in_hospital_reason')
            ->input('text', ['placeholder'=>'请输入住院原因...', 'style'=>'width:25%']);

            echo $form->field($orderPatientModel, 'admission_date')->widget(DateControl::classname(),[
                'type'=>DateControl::FORMAT_DATE,
                'options'=>[
                    'readonly'=>true,
                    'options'=>['placeholder' => '请输入住院日期','style'=>'width:19%'],
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'format' => 'yyyy-MM-dd',
                        'todayHighlight' => true,
                        'autoclose' => true
                    ]
                ]
            ]);
            echo $form->field($orderPatientModel, 'room_no')
                ->input('text', ['placeholder'=>'请输入病房号...', 'style'=>'width:25%']);
            echo $form->field($orderPatientModel, 'bed_no')
                ->input('text', ['placeholder'=>'请输入床号...', 'style'=>'width:25%']);
            ?>
        </div>
    </div>

    <!--订单信息-->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">订单信息</h3>
        </div>
        <div class="panel-body">
            <?php
            echo $form->field($model, 'hospital_id')->widget(Select2::classname(), [
                'data' => ['1'=>'1','2'=>'3','3'=>'北京儿童医院','4'=>'北京天坛医院'],
                'options' => ['placeholder' => '请选择医院','style'=>'width:25%'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('医院');

            ?>
        </div>
    </div>

    <?php

    echo Html::submitButton($model->isNewRecord ? '创建订单' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>
    <div style="margin-bottom: 15px"></div>
</div>
