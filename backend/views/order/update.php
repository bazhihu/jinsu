<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\models\OrderPatient;
use kartik\datecontrol\DateControl;
use backend\models\OrderMaster;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = '修改订单';

?>
<div class="order-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="order-master-form">
        <?php
        $form = ActiveForm::begin([
            'type'=>ActiveForm::TYPE_HORIZONTAL,
            'staticOnly'=>true,
            'formConfig'=>['labelSpan'=>4]
        ]);
        ?>

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">订单信息</h3>
            </div>
            <div class="panel-body">
                <?php
                echo Form::widget([ // fields with labels
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>3,
                    'attributes'=>[
                        'order_no'=>['type'=>Form::INPUT_TEXT],
                        'mobile'=>['type'=>Form::INPUT_TEXT,'label'=>'用户帐号'],
                        'total_amount'=>['type'=>Form::INPUT_TEXT]
                    ]
                ]);

                echo Form::widget([ // fields with labels
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>3,
                    'attributes'=>[
                        'start_time'=>['type'=>Form::INPUT_TEXT],
                        'end_time'=>['type'=>Form::INPUT_TEXT],
                    ]
                ]);

                echo Form::widget([ // fields with labels
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>3,
                    'attributes'=>[
                        'worker_no'=>['type'=>Form::INPUT_TEXT],
                        'worker_name'=>['type'=>Form::INPUT_TEXT],
                    ]
                ]);

                echo Form::widget([ // fields with labels
                    'model'=>$orderPatientModel,
                    'form'=>$form,
                    'columns'=>3,
                    'attributes'=>[
                        'name'=>['type'=>Form::INPUT_TEXT,'label'=>'患者姓名'],
                        'patient_state'=>[
                            'type'=>Form::INPUT_RAW,
                            'value'=>'<div class="form-group"><label class="col-md-4 control-label">患者健康状况</label>
                                <div class="col-md-8"><div class="form-control-static">'
                                .OrderPatient::$patientStateLabels[$model->patient_state].
                                '</div></div></div>'
                        ],
                    ]
                ]);
                ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>


        <?php
        $orderStatus = [
            OrderMaster::ORDER_STATUS_IN_SERVICE
        ];
        if(in_array($model->order_status, $orderStatus)):

        $form = ActiveForm::begin([
            'type'=>ActiveForm::TYPE_HORIZONTAL
        ]);
        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">修改订单时间</h3>
            </div>
            <div class="panel-body">
                <?php
                echo Form::widget([ // fields with labels
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>1,
                    'attributes'=>[
                        'reality_end_time'=>[
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>DateControl::classname(),
                            'options'=>[
                                'type'=>DateControl::FORMAT_DATE,
                                'options'=>[
                                    'options'=>[
                                        'placeholder'=>'请选择结束时间...',
                                        'style'=>'width:19%'
                                    ]
                                ]
                            ]
                        ],
                    ]
                ]);

                echo Html::submitButton('更新结束时间', [
                    'class'=>'btn btn-primary',
                    'name'=>'update_end_time',
                    'value'=>'true'
                ]);
                ?>
            </div>
        </div>
        <?php endif;?>
        <div style="margin-bottom: 15px"></div>
    </div>



</div>
