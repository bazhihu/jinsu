<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\HospitalDepartmentRelation $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="hospital-department-relation-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter ID...', 'maxlength'=>11]], 

'hospital_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Hospital ID...', 'maxlength'=>11]], 

'department_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Department ID...', 'maxlength'=>11]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
