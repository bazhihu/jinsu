<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    div.required .label:before {
        content: "* ";
        color: red;
    }
</style>
<div class="comment-form">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">评价</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'star'=>[
                    'type'=> Form::INPUT_RADIO_LIST,
                    'items'=>['1'=>'一星','2'=>'二星','3'=>'三星','4'=>'四星','5'=>'五星'],
                    'options'=>['inline'=>true]
                ],
                'content'=>[
                    'type'=> Form::INPUT_TEXTAREA,
                    'options'=>['placeholder'=>'请输入评价内容...',
                    'maxlength'=>255,
                        'style'=>'width:50%']],
            ]
            ]);
            echo Html::submitButton($model->isNewRecord ? Yii::t('app', '添加') : Yii::t('app', '编辑'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
            ActiveForm::end(); ?>
        </div>
    </div>
</div>