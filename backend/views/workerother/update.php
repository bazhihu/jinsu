<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\Models\Workerother $model
 */

$this->title = 'Update Workerother: ' . ' ' . $model->worker_id;
$this->params['breadcrumbs'][] = ['label' => 'Workerothers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->worker_id, 'url' => ['view', 'id' => $model->worker_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="workerother-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
