<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\Hospitals $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="hospitals-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

        'name'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>255]
        ],
        'phone'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'Enter Phone...', 'maxlength'=>11]
        ],
        'pinyin'=>[
            'type'=> Form::INPUT_TEXT,
            'options'=>['placeholder'=>'Enter Phone...', 'maxlength'=>11]
        ],
    ]
    ]);
    echo $form->field($model, 'province_id')->widget(Select2::classname(), [
            'data' => \backend\models\City::getList(1),
            'options' => ['placeholder' => 'Select ...'],
    ]);
    echo $form->field($model, 'city_id')->widget(DepDrop::classname(), [
        'data'=> $model->province_id?\backend\models\City::getList(['parent_id'=>$model->province_id]):"",
        'options' => ['placeholder' => 'Select ...'],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
            'depends'=>['hospitals-province_id'],
            'url' => Url::to(['/city/subcat']),
            'loadingText' => 'Loading child level 1 ...',
        ]
    ]);
    echo $form->field($model, 'area_id')->widget(DepDrop::classname(), [
        'data'=> $model->city_id?\backend\models\City::getList(['parent_id'=>$model->city_id]):"",
        'options' => ['placeholder' => 'Select ...'],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
            'depends'=>['hospitals-province_id', 'hospitals-city_id'],
            'url' => Url::to(['/city/prod']),
            'loadingText' => 'Loading child level 2 ...',
        ]
    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', '修改'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
