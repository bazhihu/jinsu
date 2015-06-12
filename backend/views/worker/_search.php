<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use backend\models\Worker;
use backend\models\City;
use backend\models\Hospitals;
use kartik\widgets\DepDrop;

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
            <?= $form->field($model,'worker_id')
                ->input('text',['placeholder'=>'护工编号','style'=>'width:135px'])?>

            <?= $form->field($model,'name')
                ->input('text',['placeholder'=>'护工姓名','style'=>'width:135px'])->label("姓名") ?>

            <?= $form->field($model,'gender')
                ->dropDownList(['男'=>'男','女'=>'女'],['prompt'=>'请选择'])->label("性别") ?>

           <?= $form->field($model,'native_province')
               ->widget(Select2::classname(),[
               'data' => City::getList(1),
               'options' => ['placeholder' => '请选择','style'=>'width:140px'],
               'pluginOptions' => [
                   'allowClear' => true
               ],
           ])->label('籍贯');?>

            <?= $form->field($model, 'city_id')->widget(\kartik\widgets\Select2::classname(),[
                'data' => \backend\models\City::getList(null, 3),
                'options' => ['placeholder' => '请选择','style'=>'width:110px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>

            <?= $form->field($model, 'hospital_id')->widget(DepDrop::className(),[
                'type' => DepDrop::TYPE_SELECT2,
                'data'=> $model->city_id ? Hospitals::getList(0, $model->city_id):[''=>'请选择'],
                'options' => ['placeholder' => '请选择','style'=>'width:280px'],
                'pluginOptions'=>[
                    'depends'=>['workersearch-city_id'],
                    'placeholder'=>'请选择',
                    'url'=>Url::to(['hospitals/list/']),
                ]
            ])?>

            <?= $form->field($model,'level')
                ->dropDownList(Worker::$workerLevelLabel,['prompt'=>'请选择']);?>

            <?= $form->field($model,'price')
                ->dropDownList(['1'=>'50-150','2'=>'150-250','3'=>'250以上'],['prompt'=>'请选择']); ?>

            <?= $form->field($model,'status')
                ->dropDownList(['1'=>'在职','2'=>'离职'],['prompt'=>'请选择'])->label("工作状态") ?>

            <?= $form->field($model,'audit_status')
                ->dropDownList(['1'=>'上线','2'=>'下线'],['prompt'=>'请选择'])->label("上线状态") ?>

            <?= $form->field($model,'chinese_level')->widget(Select2::classname(),[
                'data' => Worker::$chineselevelLabel,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('普通话水平');?>

            <?= $form->field($model,'pic')
                ->dropDownList([1=>'有', 2=>'无'],['prompt'=>'请选择'])
                ->label("是否有照片");
            ?>

            <div class="form-group" style="margin-top: 30px;">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>