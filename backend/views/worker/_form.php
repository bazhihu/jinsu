<?php

use yii\helpers\Html;
use yii\helpers\Url;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use backend\models\Departments;


/**
 * @var yii\web\View $this
 * @var backend\Models\Worker $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="worker-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'name'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'请输入姓名...', 'maxlength'=>20,'style'=>'width:50%']
        ],

        'idcard'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'请输入身份证号...', 'maxlength'=>20,'style'=>'width:50%']
        ],

        'gender'=>[
            'type'=> Form::INPUT_RADIO_LIST,
            'options'=>['placeholder'=>'请选择性别...'], 'items'=>['男'=>'男','女'=>'女'], 'options'=>['inline'=>true]
        ],

        'birth'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
            'options'=>[
                'options'=>[
                    'options'=>['placeholder'=>'请选择出生日期...','style'=>'width:30%']
                ],
                'type'=>DateControl::FORMAT_DATE,
                'displayFormat' => 'yyyy-MM-dd',
                'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
            ],
        ],

        'marriage'=>[
            'type'=> Form::INPUT_RADIO_LIST,
            'options'=>['placeholder'=>'请选择婚姻状况...'],
            'items'=>['1'=>'已婚','2'=>'未婚'], 'options'=>['inline'=>true]
        ],

        'education'=>[
            'type'=> Form::INPUT_RADIO_LIST,
            'options'=>['placeholder'=>'请选择文化程度...'],
            'items'=>\backend\Models\Worker::getEducationLevel(),
            'options'=>['inline'=>true]
        ],

        'politics'=>[
            'type'=> Form::INPUT_RADIO_LIST,
            'options'=>['placeholder'=>'请选择政治面貌...'],
            'items'=>\backend\Models\Worker::getPoliticsLevel(),
            'options'=>['inline'=>true]
        ],

       'chinese_level'=>[
           'type'=> Form::INPUT_RADIO_LIST,
           'options'=>['placeholder'=>'请选择普通话水平...'],
           'items'=>\backend\Models\Worker::getChineseLevel(), 'options'=>['inline'=>true]
       ],

       'certificate'=>[
           'type'=> Form::INPUT_CHECKBOX_LIST,
           'options'=>['placeholder'=>'请选择资质证书...'],
           'items'=>\backend\Models\Worker::getCertificate(),
           'options'=>['inline'=>true], 'maxlength'=>10
       ],

        'phone1'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'请输入手机号1...', 'maxlength'=>12,'style'=>'width:50%']
        ],

        'phone2'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'请输入手机号2...', 'maxlength'=>11,'style'=>'width:50%']
        ],

        'level'=>[
            'type'=> Form::INPUT_RADIO_LIST,
            'options'=>['placeholder'=>'请选择护工等级...'],'items'=>\backend\Models\Worker::getWorkerLevel(), 'options'=>['inline'=>true]
        ],

        'price'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'请输入服务价格...','style'=>'width:50%']
        ],

        'status'=>[
            'type'=> Form::INPUT_RADIO_LIST,
            'options'=>['placeholder'=>'请选择工作状态...'],'items'=>['1'=>'在职','2'=>'离职'], 'options'=>['inline'=>true]
        ],

        'start_work'=>[
            'type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
            'options'=>[
                'options'=>[
                    'options'=>['placeholder'=>'请选择入行时间...','style'=>'width:30%']
                ],
                'type'=>DateControl::FORMAT_DATE,
                'displayFormat' => 'yyyy-MM-dd',
                'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
            ],
        ],

        'place'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'请输入户口所在地...', 'maxlength'=>255,'style'=>'width:50%']
        ]
    ]
    ]);

    echo $form->field($model, 'nation')->widget(Select2::classname(), [
        'data' =>\backend\Models\Worker::getNation(),
        'options' => ['placeholder' => '请选择民族','style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('民族');

    //户口所在地
    echo $form->field($model, 'birth_place')->dropDownList( \backend\models\City::getList(1), ['id'=>'birth_place','style'=>'width:30%','placeholder'=>'请选择',]);

    // 户口所在地 Child # 1
    echo $form->field($model, 'birth_place_city')->widget(DepDrop::classname(), [
        'options'=>['id'=>'birth_place_city','style'=>'width:30%'],
        'pluginOptions'=>[
            'depends'=>['birth_place'],
            'placeholder'=>'请选择',
            'url'=>Url::to(['worker/getcity']),
            'initialize' => true
        ]

    ])->label('');

    //户口所在地 Child # 2
    echo $form->field($model, 'birth_place_area')->widget(DepDrop::classname(), [
        'options'=>['style'=>'width:30%'],
        'pluginOptions'=>[
            'depends'=>[ 'birth_place_city'],
            'placeholder'=>'请选择',
            'url'=>Url::to(['worker/getarea']),
            'initialize' => true
        ]
    ])->label('');

    //籍贯
    echo $form->field($model, 'native_province')->widget(Select2::classname(), [
        'data' => \backend\models\City::getList(1),
        'options' => ['placeholder' => '请选择籍贯','style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('籍贯');

    // 常驻医院
    echo $form->field($model, 'hospital_id')->widget(Select2::classname(), [
        'data' =>   \backend\models\Hospitals::getList('110000'),
        'addon' => 1,
        'options' => ['placeholder' => '请选择常驻医院','multiple'=>true,'style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumInputLength' => 10
        ],
    ])->label('常驻医院');

    // 常驻科室
    echo $form->field($model, 'office_id')->widget(Select2::classname(), [
        'data' =>   \backend\models\Departments::getList(),
        'addon' => 1,
        'options' => ['placeholder' => '请选择常驻科室','multiple'=>true,'style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumInputLength' => 10
        ],
    ])->label('常驻科室');

    // 擅长护理的疾病
    echo $form->field($model, 'good_at')->widget(Select2::classname(), [
        'data' =>   \backend\models\Departments::getList(),
        'addon' => 1,
        'options' => ['placeholder' => '请选择擅长护理的疾病','multiple'=>true,'style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumInputLength' => 10
        ],
    ])->label('擅长护理的疾病');

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
<?php
/*?$js = <<<EOF
var birth_place_city = $model->birth_place_city;
    jQuery(document).ready(function () {
        jQuery("#birth_place_city").val(birth_place_city);
        console.log(jQuery("#birth_place_city").val());
    });
EOF;

$this->registerJs($js, \yii\web\View::POS_READY);*/
?>