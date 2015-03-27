<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\Models\WorkerotherSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="workerother-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'worker_id') ?>

    <?= $form->field($model, 'ext1') ?>

    <?= $form->field($model, 'ext2') ?>

    <?= $form->field($model, 'ext3') ?>

    <?= $form->field($model, 'ext4') ?>

    <?php // echo $form->field($model, 'info_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
