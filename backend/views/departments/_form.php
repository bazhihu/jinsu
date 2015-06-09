<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use Yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var backend\models\Departments $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="departments-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    echo $form->field($model, 'parent_id')->dropDownList(\backend\models\Departments::getParent());
    echo $form->field($model, 'name');
    echo $form->field($model, 'pinyin');
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
