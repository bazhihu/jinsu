<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use backend\models\Worker;
use backend\models\City;
use backend\models\Hospitals;
use backend\models\Departments;

/**
 * @var yii\web\View $this
 * @var backend\models\WorkerSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
</style>

<div class="worker-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => [
            'showLabels' => true,
        ],

    ]); ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">检索</h3>
        </div>
        <div class="panel-body">
            <?= $form->field(
                $model,
                'worker_id'
            )->input('text',['placeholder'=>'请输入护工编号...','style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'name'
            )->input('text',['placeholder'=>'请输入姓名...','style'=>'width:120px'])->label("姓名") ?>

            <?= $form->field(
                $model,
                'gender',
                [
                    //'labelOptions'=> ['class'=>'col-sm-5 col-md-5 col-lg-5']
                ]
            )->dropDownList(['男'=>'男','女'=>'女'],['prompt'=>'请选择'])->label("性别") ?>

           <?= $form->field(
               $model,
               'native_province',
               [
                   //'labelOptions'=> ['class'=>'col-sm-5 col-md-5 col-lg-5']
               ]
           )->widget(Select2::classname(),[
               'data' => City::getList(1),
               'options' => ['placeholder' => '请选择','style'=>'width:140px'],
               'pluginOptions' => [
                   'allowClear' => true
               ],
           ])->label('籍贯');?>

            <?= $form->field(
                $model,
                'hospital_id',
                [
                    //'labelOptions'=> ['class'=>'col-sm-6 col-md-6 col-lg-6']
                ]
            )->widget(Select2::classname(),[
                'data' =>  Hospitals::getList('110000'),
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('常驻医院');?>

            <?= $form->field(
                $model,
                'level'
            )->dropDownList([Worker::getWorkerLevel()],['prompt'=>'请选择'])->label("护工等级") ?>

            <?= $form->field(
                $model,
                'price'
            )->dropDownList(['1'=>'50-150','2'=>'150-250','3'=>'250以上'],['prompt'=>'请选择']); ?>

            <?= $form->field(
                $model,
                'status',
                [
                    //'labelOptions'=> ['class'=>'col-sm-6 col-md-6 col-lg-6']
                ]
            )->dropDownList(['1'=>'在职','2'=>'离职'],['prompt'=>'请选择'])->label("工作状态") ?>

            <?= $form->field(
                $model,
                'chinese_level',
                [
                    //'labelOptions'=> ['class'=>'col-sm-6 col-md-6 col-lg-6']
                ],
                [
                    'pluginOptions' => ['allowClear' => true]
                ]
            )->widget(Select2::classname(),[
                'data' => Worker::getChineseLevel(),
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('普通话水平');?>

            <?= $form->field(
                $model,
                'good_at',
                [
                    //'labelOptions'=> ['class'=>'col-sm-6 col-md-6 col-lg-6']
                ]
            )->widget(Select2::classname(),[
                'data' =>   Departments::getList(),
                'options' => ['placeholder' => '请选择','style'=>'width:160px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('擅长护理疾病');?>

            <div class="form-group" style="margin-top: 30px;">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>