<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = 'Update Order Master: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
