<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use backend\models\Hospitals;


/* @var $this yii\web\View */
/* @var $model backend\models\WorkerAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
</style>
<div class="worker-account-search">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">检索</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>

            <?= $form->field($model, 'worker_id') ?>

            <?= $form->field($model, 'worker_name') ?>

            <?= $form->field($model, 'city_id')->widget(\kartik\widgets\Select2::classname(),[
                'data' => \backend\models\City::getList(null, true),
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
                    'depends'=>['workeraccountsearch-city_id'],
                    'placeholder'=>'请选择',
                    'url'=>Url::to(['hospitals/list/']),
                ]
            ])?>

            <div class="form-group" style="margin-top: 30px">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
