<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\Models\WorkerSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="worker-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'worker_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'birth') ?>

    <?= $form->field($model, 'birth_place') ?>

    <?php // echo $form->field($model, 'native_province') ?>

    <?php // echo $form->field($model, 'nation') ?>

    <?php // echo $form->field($model, 'marriage') ?>

    <?php // echo $form->field($model, 'education') ?>

    <?php // echo $form->field($model, 'politics') ?>

    <?php // echo $form->field($model, 'idcard') ?>

    <?php // echo $form->field($model, 'chinese_level') ?>

    <?php // echo $form->field($model, 'certificate') ?>

    <?php // echo $form->field($model, 'start_work') ?>

    <?php // echo $form->field($model, 'place') ?>

    <?php // echo $form->field($model, 'phone1') ?>

    <?php // echo $form->field($model, 'phone2') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'hospital_id') ?>

    <?php // echo $form->field($model, 'office_id') ?>

    <?php // echo $form->field($model, 'good_at') ?>

    <?php // echo $form->field($model, 'add_date') ?>

    <?php // echo $form->field($model, 'adder') ?>

    <?php // echo $form->field($model, 'edit_date') ?>

    <?php // echo $form->field($model, 'editer') ?>

    <?php // echo $form->field($model, 'total_score') ?>

    <?php // echo $form->field($model, 'star') ?>

    <?php // echo $form->field($model, 'total_order') ?>

    <?php // echo $form->field($model, 'good_rate') ?>

    <?php // echo $form->field($model, 'total_comment') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
