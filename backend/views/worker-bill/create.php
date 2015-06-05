<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WorkerBill */

$this->title = 'Create Worker Bill';
$this->params['breadcrumbs'][] = ['label' => 'Worker Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-bill-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
