<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use backend\models\Hospitals;
use backend\models\Departments;
use backend\models\Worker;
use backend\models\OrderPatient;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    div.required label:before {
        content: " *";
        color: #ff0000;
    }
    red{color: #ff0000;}
    .btn{margin:5px}
    form{margin-bottom: 15px}
</style>
<div class="order-master-form">
    <?php
    $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_HORIZONTAL,
        //'action'=>Yii::$app->urlManager->createUrl('order/create')
    ]);
    ?>

    <div class="row">
        <div class="col-sm-6">
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
                                'label'=>'手机号',
                                'type'=> Form::INPUT_TEXT,
                                //'container'=>['class'=>'has-warning'],
                                'options'=>[
                                    'placeholder'=>'请输入手机号...',
                                    'maxlength'=>11,
                                    'style'=>'width:26%',
                                    'readOnly'=>$model->isNewRecord ? false : true,
                                    //用户来电将电话号码显示在表单中
                                    'value'=>isset($_GET['callid'])? $_GET['callid'] : $model->mobile
                                ],
                            ],
                            'contact_name'=>[
                                'type'=> Form::INPUT_TEXT,
                                'options'=>[
                                    'placeholder'=>'请输入联系人姓名...',
                                    'maxlength'=>4,
                                    'style'=>'width:26%'
                                ],
                            ],
                            'contact_telephone'=>[
                                'type'=> Form::INPUT_TEXT,
                                'options'=>[
                                    'placeholder'=>'请输入备用电话...',
                                    'style'=>'width:26%'
                                ],
                            ],
//                            'contact_address'=>[
//                                'type'=> Form::INPUT_TEXT,
//                                'options'=>[
//                                    'placeholder'=>'请输入住址...',
//                                    'style'=>'width:26%'
//                                ],
//                            ],
                        ]
                    ]);?>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">订单信息</h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo $form->field($model, 'hospital_id')->widget(Select2::classname(), [
                        'data' => Hospitals::getList(),
                        'options' => ['type'=> Form::INPUT_WIDGET,'placeholder' => '请选择医院...','style'=>'width:40%'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('医院');
                    echo $form->field($model, 'department_id')->widget(Select2::classname(), [
                        'data' => Departments::getList(),
                        'options' => ['placeholder' => '请选择科室...','style'=>'width:40%'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('科室');

                    //续单
                    if($model->is_continue){
                        echo $form->field($model, 'is_continue', ['options'=>['style'=>'display:none']])->hiddenInput()->label(false);
                        echo $form->field($model, 'worker_no', ['options'=>['style'=>'display:none']])->hiddenInput()->label(false);
                        echo $form->field($model, 'worker_name', ['options'=>['style'=>'display:none']])->hiddenInput()->label(false);
                        echo $form->field($model, 'base_price', ['options'=>['style'=>'display:none']])->hiddenInput()->label(false);
                        echo $form->field($model, 'order_type', ['options'=>['style'=>'display:none']])->hiddenInput()->label(false);
                    }

                    echo $form->field($model, 'worker_level')->widget(Select2::classname(), [
                        'hideSearch' => true,
                        'data' => Worker::getWorkerLevel(),
                        'options' => ['placeholder' => '请选择护工等级...','style'=>'width:40%'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('护工等级')->hint(Worker::getWorkerPriceHint());

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
                                'label' => '<red>*</red>订单时间',
                                'attributes'=>[
                                    'start_time' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\widgets\DatePicker',
                                        'hint'=>'请输入开始时间(yyyy-mm-dd)',
                                        'options'=>[
                                            'options'=>['placeholder'=>'开始时间...'],
                                            'pluginOptions'=>[
                                                //'startDate'=>date('Y-m-d'),
                                                'todayHighlight' => true,
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd 09:00:00'
                                            ]
                                        ]
                                    ],
                                    'end_time'=>[
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\widgets\DatePicker',
                                        'hint'=>'请输入结束时间(yyyy-mm-dd)',
                                        'options'=>[
                                            'options'=>['placeholder'=>'结束时间...'],
                                            'pluginOptions'=>[
                                                //'startDate'=>date('Y-m-d', mktime(0,0,0,date('m'),date('d')+1,date('Y'))),
                                                'todayHighlight' => true,
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd 09:00:00'
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ]);
                    echo $form->field($model, 'remark')->textarea(['rows'=>2, 'style'=>'width:90%']);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
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
                                    'maxlength'=>6,
                                    'style'=>'width:198px'
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
                                    'style'=>'width:198px'
                                ],
                            ],
                        ]
                    ]);

                    echo $form->field($orderPatientModel, 'height', [
                        'addon' => ['append' => ['content'=>'cm'],'groupOptions'=>['style'=>'width:198px']]
                    ]);
                    echo $form->field($orderPatientModel, 'weight', [
                        'addon' => ['append' => ['content'=>'kg'],'groupOptions'=>['style'=>'width:198px']]
                    ]);
                    $orderPatientModel->patient_state = OrderPatient::PATIENT_STATE_OK;
                    echo $form->field($orderPatientModel, 'patient_state')
                        ->radioList([
                                OrderPatient::PATIENT_STATE_DISABLED=>'不能自理',
                                OrderPatient::PATIENT_STATE_OK=>'能自理'
                            ],
                            ['inline'=>true]
                        )->label('患者健康状况');

                    echo Form::widget([
                        'model' => $orderPatientModel,
                        'form' => $form,
                        'columns' => 1,
                        'attributes' => [
                            'admission_date'=>[
                                'type'=>Form::INPUT_WIDGET,
                                'widgetClass'=>'\kartik\widgets\DatePicker',
                                'options'=>[
                                    'options'=>[
                                        'style'=>'width:120px',
                                    ],
                                    'pickerButton'=>['title'=>'请选择住院日期'],
                                    'pluginOptions'=>[
                                        'todayHighlight' => true,
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]
                            ],
                        ]
                    ]);

                    echo $form->field($orderPatientModel, 'room_no')
                        ->input('text', ['placeholder'=>'请输入病房号...', 'style'=>'width:198px']);
                    echo $form->field($orderPatientModel, 'bed_no')
                        ->input('text', ['placeholder'=>'请输入床号...', 'style'=>'width:198px']);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    $class = $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary';
    echo Html::submitButton($model->isNewRecord ? '确定下单' : '更新', ['class'=>$class,'name'=>'fast_submit', 'value'=>'true']);
    echo Html::button('计算订单价格', ['class'=>'btn btn-info js-calculate-price']);
    ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    //隐藏患者健康状况
    $('#orderpatient-patient_state').parents('.form-group').hide();

    $('.js-calculate-price').click(function(){
        var workerLevel = $('#ordermaster-worker_level').val();
        var startTime = $('#ordermaster-start_time').val();
        var endTime = $('#ordermaster-end_time').val();
        var patientState = $('input[name="OrderPatient[patient_state]"]:checked').val();
        if(workerLevel.length <= 0 || startTime.length <= 0 || endTime.length <= 0 || !patientState){
            alert('护工等级、订单时间段、患者健康状况填后才能计算订单价格。');
            return false;
        }
        var arr = startTime.split("-");
        var sTime = new Date(arr[0], arr[1], arr[2]);
        var arr = endTime.split("-");
        var eTime = new Date(arr[0], arr[1], arr[2]);

        if (sTime.getTime() >= eTime.getTime()) {
            alert('开始时间不能大于等于结束时间。');
            return false;
        }

        <?php $url = Yii::$app->urlManager->createUrl(['order/calculate']);?>

        $("#priceDetail").load(
            '<?php echo $url;?>',
            {worker_level: workerLevel,start_time:startTime,end_time:endTime,patient_state:patientState}
        );

        jQuery('#orderPriceModal').modal({"show":true});
    });
</script>
<?php
\yii\bootstrap\Modal::begin([
    'header' => '<strong>订单价格明细</strong>',
    'id'=>'orderPriceModal',
    'size'=>'modal-lg',
]);
echo '<div id="priceDetail"></div>';

\yii\bootstrap\Modal::end()
?>