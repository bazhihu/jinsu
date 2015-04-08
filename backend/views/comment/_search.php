<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
/**
 * @var yii\web\View $this
 * @var backend\models\CommentSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-commentsearch-comment_date_begin{
        float:left;width:230px
    }
    .field-commentsearch-comment_date_end{
        float:left;width:230px
    }
</style>
<div class="comment-search">
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
                'order_no'
            )->input('text',['placeholder'=>'请输入订单号...','style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'worker_id'
            )->input('text',['placeholder'=>'请输入护工编号...','style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'worker_name'
            )->input('text',['placeholder'=>'请输入护工姓名...','style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'status'
            )->dropDownList(['1'=>'待审核','2'=>'审核通过','3'=>'审核未通过'],['prompt'=>'请选择'])->label("审核状态") ?>

            <?= $form->field($model, 'comment_date_begin')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:150px']
                ]
            ]);?>

            <?= $form->field($model, 'comment_date_end')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:150px']
                ]
            ]);?>

            <div class="form-group" style="margin-top: 30px;">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
