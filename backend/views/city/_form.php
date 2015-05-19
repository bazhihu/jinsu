<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\City $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter ID...']],

            'type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Type...']],

            'parent_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Parent ID...']],

            'group_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Group ID...']],

            'display'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Display...']],

            'continent_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Continent ID...']],

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>255]],

            'zip'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Zip...', 'maxlength'=>20]],

            'wcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Wcode...', 'maxlength'=>10]],
        ]
    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    ?>
</div>
