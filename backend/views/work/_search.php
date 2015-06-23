
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model backend\Models\WorkSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-worksearch-add_date_begin{
        float:left;width:230px
    }
    .field-worksearch-add_date_end{
        float:left;width:230px
    }
</style>
<div class="work-search">
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
            )->input('text',['style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'worker_name'
            )->input('text',['style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'mobile'
            )->input('text',['style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'user_name'
            )->input('text',['style'=>'width:135px'])?>

            <?= $form->field(
                $model,
                'from_where'
            )->dropDownList(['400'=>'400','ios'=>'ios','android'=>'android','h5'=>'h5'],['prompt'=>'请选择'])->label("渠道") ?>

            <?= $form->field(
                $model,
                'status'
            )->dropDownList([1=>'未解决',2=>'已解决'],['prompt'=>'请选择'])->label("状态") ?>

            <?= $form->field(
                $model,
                'type'
            )->dropDownList([1=>'投诉',2=>'表扬',3=>'咨询',4=>'建议'],['prompt'=>'请选择'])->label("类型") ?>

            <?= $form->field($model, 'add_date_begin')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:150px']
                ]
            ]);?>

            <?= $form->field($model, 'add_date_end')->widget(DateControl::classname(), [
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

    <?php ActiveForm::end(); ?>

</div>