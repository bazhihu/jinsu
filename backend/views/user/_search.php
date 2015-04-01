<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\Growl;
/**
 * @var yii\web\View $this
 * @var backend\models\UserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
        'formConfig'=>[
            'labelSpan'=>1
        ],
    ]); ?>


    <?= $form->field(
        $model,
        'mobile',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入用户名...'])->label("用户名") ?>

    <?= $form->field(
        $model,
        'nickname',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入昵称...'])->label("昵称") ?>

    <?= $form->field(
        $model,
        'name',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入姓名...'])->label("姓名") ?>

    <?= $form->field(
        $model,
        'status',
        [
            'labelOptions'=> ['class'=>'col-sm-5 col-md-5 col-lg-5']
        ]
    )->dropDownList(['1'=>'正常','2'=>'禁用'],['prompt'=>'请选择'])->label("状态") ?>

    <div class="form-group" style="padding-top: 25px">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
