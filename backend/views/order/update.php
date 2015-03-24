<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = 'Update Order Master: ' . ' ' . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Order Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
