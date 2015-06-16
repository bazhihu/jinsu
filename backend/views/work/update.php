<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\Models\Work */

$this->title = 'Update Work: ' . ' ' . $model->work_id;
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->work_id, 'url' => ['view', 'id' => $model->work_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
