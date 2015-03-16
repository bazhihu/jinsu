<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="admin-user-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Status...']], 

'username'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Username...', 'maxlength'=>255]], 

'auth_key'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Auth Key...', 'maxlength'=>32]], 

'password_hash'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Hash...', 'maxlength'=>255]], 

'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Email...', 'maxlength'=>255]], 

'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

'role'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Role...']], 

'password_reset_token'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Reset Token...', 'maxlength'=>255]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
