<?php

use yii\helpers\Html;
use yii\helpers\Url;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use backend\models\Worker;
use backend\models\Departments;
use backend\models\City;
use backend\models\Hospitals;

/**
 * @var yii\web\View $this
 * @var backend\models\Worker $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="worker-form">
    <div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$this->title?></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
                'type'=>ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'options' => ['enctype' => 'multipart/form-data']
            ]
        );

        //echo $form->field($model, 'pic')->fileInput() ;
        echo $form->field($model, 'pic')->widget(\kartik\file\FileInput::classname(), [
            'class' =>'col-md-5',
            'pluginOptions' => [
                'options'=>['style'=>'width:10%'],
                'showUpload' => false,
                'browseLabel' => '浏览',
                'showRemove' => false,
                //'class'=>"file-loading",
                'allowedFileExtensions' => ['jpg'],
                'maxFileSize' =>2048,
                'initialPreview'=>[
                    Html::img(Worker::workerPic($model->worker_id), [ 'alt'=>'护工照片', 'title'=>'护工照片','width'=>200,'height'=>200]),
                ],

                'initialCaption'=>"护工照片",
                'overwriteInitial'=>true
            ]
        ])->hint('要求：jpg格式，200*200，小于2M');

        echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'name'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>['placeholder'=>'请输入姓名...', 'maxlength'=>20,'style'=>'width:30%']
            ],

            'idcard'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>['placeholder'=>'请输入身份证号...', 'maxlength'=>20,'style'=>'width:30%']
            ],

            'gender'=>[
                'type'=> Form::INPUT_RADIO_LIST,
                'options'=>['placeholder'=>'请选择性别...'],
                'items'=>['男'=>'男','女'=>'女'],
                'options'=>['inline'=>true]
            ],

            'birth'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
                'options'=>[
                    'options'=>[
                        'options'=>['placeholder'=>'请选择出生日期...','style'=>'width:26%']
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
                'items'=>Worker::getEducationLevel(),
                'options'=>['inline'=>true]
            ],

            'politics'=>[
                'type'=> Form::INPUT_RADIO_LIST,
                'options'=>['placeholder'=>'请选择政治面貌...'],
                'items'=>Worker::getPoliticsLevel(),
                'options'=>['inline'=>true]
            ],

           'chinese_level'=>[
               'type'=> Form::INPUT_RADIO_LIST,
               'options'=>['placeholder'=>'请选择普通话水平...'],
               'items'=>Worker::getChineseLevel(), 'options'=>['inline'=>true]
           ],

           'certificate'=>[
               'type'=> Form::INPUT_CHECKBOX_LIST,
               'options'=>['placeholder'=>'请选择资质证书...'],
               'items'=>Worker::getCertificate(),
               'options'=>['inline'=>true], 'maxlength'=>10
           ],

           /* 'phone1'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>['placeholder'=>'请输入手机号1...', 'maxlength'=>12,'style'=>'width:30%']
            ],

            'phone2'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>['placeholder'=>'请输入手机号2...', 'maxlength'=>11,'style'=>'width:30%']
            ],
            */
            'level'=>[
                'type'=> Form::INPUT_RADIO_LIST,
                'options'=>['placeholder'=>'请选择护工等级...'],'items'=>Worker::getWorkerLevel(), 'options'=>['inline'=>true]
            ],

            'price'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>['placeholder'=>'请输入服务价格...','style'=>'width:30%'],
                'contentAfter' => '元'

            ],

            'status'=>[
                'type'=> Form::INPUT_RADIO_LIST,
                'options'=>['placeholder'=>'请选择工作状态...'],'items'=>['1'=>'在职','2'=>'离职'], 'options'=>['inline'=>true]
            ],

            'start_work'=>[
                'type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
                'options'=>[
                    'options'=>[
                        'options'=>['placeholder'=>'请选择入行时间...','style'=>'width:26%']
                    ],
                    'type'=>DateControl::FORMAT_DATE,
                    'displayFormat' => 'yyyy-MM-dd',
                    'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
                ],
            ],

            'place'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>['placeholder'=>'请输入户口所在地...', 'maxlength'=>255,'style'=>'width:30%']
            ]
        ]
        ]);

        echo $form->field($model, 'nation')->widget(Select2::classname(), [
            'data' =>Worker::getNation(),
            'options' => ['placeholder' => '请选择民族','style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('民族');

        //户口所在地
       // $model->birth_place = 140000;
        echo $form->field($model, 'birth_place')->dropDownList(
            City::getList(1),
            [
                'id'=>'birth_place',
                'style'=>'width:30%',
                'prompt'=>'请选择',
            ]);

        // 户口所在地 Child # 1
       // $model->birth_place_city = 140300;
        echo $form->field($model, 'birth_place_city')->widget(DepDrop::classname(), [
            'options'=>[
                'id'=>'birth_place_city',
                'style'=>'width:30%'

            ],
            'pluginOptions'=>[
                'depends'=>['birth_place'],
                'placeholder'=>'请选择',
                'url'=>Url::to(['worker/getcity/','selected'=>$model->birth_place_city]),
                'initialize' => true
            ]
        ])->label('');

        //户口所在地 Child # 2
        echo $form->field($model, 'birth_place_area')->widget(DepDrop::classname(), [
            'options'=>['style'=>'width:30%'],
            'pluginOptions'=>[
                'depends'=>['birth_place_city'],
                'placeholder'=>'请选择',
                'url'=>Url::to(['worker/getarea','selected'=>$model->birth_place_area]),
                'initialize' => true
            ]
        ])->label('');

        //籍贯
        echo $form->field($model, 'native_province')->widget(Select2::classname(), [
            'data' => City::getList(1),
            'options' => ['placeholder' => '请选择籍贯','style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('籍贯');

        // 常驻医院
        echo $form->field($model, 'hospital_id')->widget(Select2::classname(), [
            'data' =>   Hospitals::getList('110000'),
            'addon' => 1,
            'options' => ['placeholder' => '请选择常驻医院','multiple'=>true,'style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true,
                'maximumInputLength' => 10
            ],
        ])->label('常驻医院');

        // 常驻科室
        echo $form->field($model, 'office_id')->widget(Select2::classname(), [
            'data' =>   Departments::getList(),
            'addon' => 1,
            'options' => ['placeholder' => '请选择常驻科室','multiple'=>true,'style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true,
                'maximumInputLength' => 10
            ],
        ])->label('常驻科室');

        // 擅长护理的疾病
//        echo $form->field($model, 'good_at')->widget(Select2::classname(), [
//            'data' =>   Departments::getList(),
//            'addon' => 1,
//            'options' => ['placeholder' => '请选择擅长护理的疾病','multiple'=>true,'style'=>'width:30%'],
//            'pluginOptions' => [
//                'allowClear' => true,
//                'maximumInputLength' => 10
//            ],
//        ])->label('擅长护理的疾病');

        echo Html::submitButton($model->isNewRecord ? Yii::t('app', '保存，下一步') : Yii::t('app', '编辑'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        if(!$model->isNewRecord){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='btn btn-primary' onclick=location.href='?r=workerother/update&worker_id=".$model->worker_id."' value='编辑其他信息'>";
        }?>
    </div>
    </div>

    <?ActiveForm::end(); ?>

</div>