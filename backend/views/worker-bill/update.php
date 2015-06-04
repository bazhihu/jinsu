<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkerBill */

$this->title = 'Update Worker Bill: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Worker Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="worker-bill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
