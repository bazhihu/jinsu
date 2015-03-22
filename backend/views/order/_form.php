<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use backend\models\Hospitals;
use backend\models\Departments;
use backend\Models\Worker;

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

            echo Form::widget([
                'model' => $orderPatientModel,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'admission_date'=>[
                        'type'=> Form::INPUT_WIDGET,
                        'widgetClass'=>DateControl::classname(),
                        'options'=>[
                            'type'=>DateControl::FORMAT_DATE,
                            'options'=>[
                                'options'=>['placeholder'=>'请选择住院日期...','style'=>'width:19%']
                            ],
                            'displayFormat' => 'yyyy-MM-dd',
                        ]
                    ],
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
                'data' => Hospitals::getList(),

                'options' => ['type'=> Form::INPUT_WIDGET,'placeholder' => '请选择医院...','style'=>'width:25%'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            echo $form->field($model, 'department_id')->widget(Select2::classname(), [
                'data' => Departments::getList(),
                'options' => ['placeholder' => '请选择科室...','style'=>'width:25%'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            echo $form->field($model, 'worker_level')->widget(Select2::classname(), [
                'hideSearch' => true,
                'data' => Worker::getWorkerLevel(),
                'options' => ['placeholder' => '请选择护工等级...','style'=>'width:25%'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

            echo Form::widget([ // nesting attributes together (without labels for children)
                'model'=>$model,
                'form'=>$form,
                'columns'=>1,
                'attributeDefaults' => [
                    'type' => Form::INPUT_TEXT,
                    'labelOptions' => ['class'=>'col-md-2'],
                    'inputContainer' => ['class'=>'col-md-10'],
                ],
                'attributes'=>[
                    'date_range' => [
                        'label' => '时间段',
                        'attributes'=>[
                            'start_time' => [
                                'type'=> Form::INPUT_WIDGET,
                                'widgetClass'=>DateControl::classname(),
                                'options'=>[
                                    'type'=>DateControl::FORMAT_DATE,
                                    'options'=>[
                                        'options'=>['placeholder'=>'开始时间...']
                                    ],
                                    'displayFormat' => 'yyyy-MM-dd',
                                ]
                            ],
                            'end_time'=>[
                                'type'=>Form::INPUT_WIDGET,
                                'widgetClass'=>DateControl::classname(),
                                'options'=>[
                                    'type'=>DateControl::FORMAT_DATE,
                                    'options'=>[
                                        'options'=>['placeholder'=>'结束时间...']
                                    ],
                                    'displayFormat' => 'yyyy-MM-dd',
                                ]
                            ],
                        ]
                    ],

                ]
            ]);
            echo $form->field($model, 'remark')->textarea(['rows'=>3]);
            ?>
        </div>
    </div>

    <?php

    echo Html::submitButton($model->isNewRecord ? '创建订单' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>
    <div style="margin-bottom: 15px"></div>
</div>
