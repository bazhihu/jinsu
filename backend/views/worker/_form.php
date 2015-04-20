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
<style>
    .file-preview {width:200px;border: none}
    .close{width:0px;}
    .input-group{width:30%}
    .clearfix{width:205px;border: 1px solid #ccc}
    div.required label:before {
        content: "* ";
        color: red;
    }
</style>

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
            'pluginOptions' => [
                'options'=>['style'=>'width:10%'],
                'showUpload' => false,
                'browseLabel' => '浏览',
                'showRemove' => false,
                //'class'=>"file-loading",
                'allowedFileExtensions' => ['jpg'],
                //'maxFileSize' =>2048,
                'initialPreview'=>[
                    Html::img(Worker::workerPic($model->worker_id), [ 'alt'=>'护工照片', 'title'=>'护工照片','width'=>160]),
                ],

                'initialCaption'=>"护工照片",
                'overwriteInitial'=>true
            ]
        ])->hint('要求：jpg格式，1024*1024');

        echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'name'=>[
                'type'=> Form::INPUT_TEXT,
                'class'=>'text-muted',
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

//            'start_work'=>[
//                'type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
//                'options'=>[
//                    'options'=>[
//                        'options'=>['placeholder'=>'请选择入行时间...','style'=>'width:100%']
//                    ],
//                    'type'=>DateControl::FORMAT_DATE,
//                    'displayFormat' => 'yyyy-MM-dd',
//                    'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
//                ],
//            ],

            'status'=>[
                'type'=> Form::INPUT_RADIO_LIST,
                'options'=>['placeholder'=>'请选择工作状态...'],'items'=>['1'=>'在职','2'=>'离职'], 'options'=>['inline'=>true]
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

            'level'=>[
                'type'=> Form::INPUT_RADIO_LIST,
                'options'=>['placeholder'=>'请选择护工等级...'],'items'=>Worker::getWorkerLevel(), 'options'=>['inline'=>true]
            ],
        ]
        ]);

        echo $form->field($model, 'price', [
            'addon' => ['append' => ['content'=>'元/天'],'groupOptions'=>['class'=>'col-md-3']]
        ])->input('text', ['placeholder'=>'请输入服务价格...']);

        echo '<div class="row">
                <div class="col-sm-12">
                    <div class="form-group field-worker-start_work">
                    <label for="worker-start_work" class="col-md-2 control-label">入行时间</label>
                    <div class="col-md-10">
                    <div id="worker-start_work">
                    <input id="start_work" name="start_work"  style="width:30%" class="time" type="text" value="'.$model->start_work.'">
                    </div>
                    </div>
                    <div class="col-md-offset-2 col-md-10"><div class="help-block"></div></div>
                    </div>
                </div>
                </div>';

        echo $form->field($model, 'nation')->widget(Select2::classname(), [
            'data' =>Worker::getNation(),
            'options' => ['placeholder' => '请选择民族','style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('民族');

        echo $form->field($model, 'place', [
            'addon' => ['groupOptions'=>['class'=>'col-md-3']],
        ])->input('text', ['placeholder'=>'请输入居住地...']);

        echo Form::widget([       // 3 column layout
            'model'=>$model,
            'form'=>$form,
            'columns'=>4,
            'class'=>'',
            'attributeDefaults' => [
                'type' => Form::INPUT_TEXT,
                'labelOptions' => ['class'=>'col-md-2'],
                'inputContainer' => ['class'=>'col-md-10'],
            ],
            'attributes'=>[
                'date_range' => [
                    'label' => '户口所在地',
                    'attributes'=>[
                        'birth_place'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> City::getList(1),
                            'value'=>$model->birth_place,
                            'options'=>['prompt'=>'请选择'],
                        ],
                        'birth_place_city'=>[
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>DepDrop::classname(),
                            'options'=>[
                                'data'=> $model->birth_place ? City::getList(['parent_id'=>$model->birth_place]):[''=>'请选择'],
                                'pluginOptions'=>[
                                    'depends'=>['worker-birth_place'],
                                    'placeholder'=>'请选择',
                                    'url'=>Url::to(['worker/getcity/']),
                                ]
                            ],
                        ],
                        'birth_place_area'=>[
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>DepDrop::classname(),
                            'options'=>[
                                'data'=> $model->birth_place_city ? City::getList(['parent_id'=>$model->birth_place_city]):[''=>'请选择'],
                                'pluginOptions'=>[
                                    'allowClear'=>true,
                                    'depends'=>['worker-birth_place_city'],
                                    'placeholder'=>'请选择',
                                    'url'=>Url::to(['worker/getarea']),
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ]);


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
            'options' => ['placeholder' => '请选择常驻医院','multiple'=>true,'style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true,
                'maximumInputLength' => 20
            ],
        ])->label('常驻医院');

        // 常驻科室
        echo $form->field($model, 'office_id')->widget(Select2::classname(), [
            'data' =>   Departments::getList(),
            'options' => ['placeholder' => '请选择常驻科室','multiple'=>true,'style'=>'width:30%'],
            'pluginOptions' => [
                'allowClear' => true,
                'maximumInputLength' => 20
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

        echo Html::submitButton($model->isNewRecord ? '保存，下一步' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        if(!$model->isNewRecord){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='btn btn-primary' onclick=location.href='?r=workerother/update&worker_id=".$model->worker_id."' value='编辑其他信息'>";
        }?>
    </div>
    </div>

    <?ActiveForm::end(); ?>

</div>
<script type="text/javascript" >
    $(document).ready(function(){
        $('#start_work').unbind('focus');
        $('#start_work').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月'});});
    });
</script>
<script type="text/javascript" src="/js/wdatepicker/wdatepicker.js"></script>