<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

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

    'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 姓名...', 'maxlength'=>20]],

    'gender'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 性别...'], 'items'=>['1'=>'男','2'=>'女'], 'options'=>['inline'=>true]],

    'birth'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
        'options'=>[
            'type'=>DateControl::FORMAT_DATE,
            'displayFormat' => 'yyyy-MM-dd',
            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
        ],

    ],

    'birth_place'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 户口所在地...', 'maxlength'=>50]],


   /* 'native_province'=>[
            'type'=> Form::INPUT_WIDGET,'widgetClass'=>Select2::classname(),
            'options'=>['placeholder'=>'Enter 籍贯...', 'maxlength'=>50,'data' => \backend\models\Hospitals::getList()],
            'pluginOptions' => ['allowClear' => true]
    ],*/


    'place'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 居住地...', 'maxlength'=>255]],

    'nation'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 民族...']],

    'marriage'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 婚姻状况...'], 'items'=>['1'=>'已婚','2'=>'未婚'], 'options'=>['inline'=>true]],

    'education'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 文化程度...'], 'items'=>['1'=>'男','2'=>'女'], 'options'=>['inline'=>true]],

    'politics'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 政治面貌...'], 'items'=>['1'=>'群众','2'=>'团员','3'=>'中共党员','4'=>'民主党派','5'=>'无党派人士','6'=>'其他'], 'options'=>['inline'=>true]],

    'idcard'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 身份证号...', 'maxlength'=>20]],

    'chinese_level'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 普通话水平...'], 'items'=>['1'=>'一般','2'=>'良好','3'=>'熟练'], 'options'=>['inline'=>true]],

    'certificate'=>['type'=> Form::INPUT_CHECKBOX_LIST, 'options'=>['placeholder'=>'Enter 资质证书...'],'items'=>['1'=>'健康证','2'=>'护理证','3'=>'暂住证'], 'options'=>['inline'=>true], 'maxlength'=>10],

    'phone1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 手机号1...', 'maxlength'=>12]],

    'phone2'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 手机号2...', 'maxlength'=>11]],

    'level'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 护工等级...'],'items'=>['1'=>'中级','2'=>'高级','3'=>'特级'], 'options'=>['inline'=>true]],

    'price'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 服务价格...']],

    'status'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 工作状态...'],'items'=>['1'=>'在职','2'=>'离职'], 'options'=>['inline'=>true]],

    'hospital_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 常驻医院id(多个用逗号隔开)...', 'maxlength'=>50]],

    'office_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 常驻科室id(多个用逗号隔开)...', 'maxlength'=>50]],

    'good_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 擅长护理的疾病id(多个用逗号隔开)...', 'maxlength'=>50]],

    'start_work'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
        'options'=>['type'=>DateControl::FORMAT_DATE,'displayFormat' => 'yyyy-MM-dd',
        'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
        ],
    ]]
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
