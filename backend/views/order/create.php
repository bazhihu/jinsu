<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = '新增订单';
//$this->params['breadcrumbs'][] = ['label' => 'Order Masters', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'orderPatientModel' => $orderPatientModel,
        'action' => Yii::$app->urlManager->createUrl('order/create')
    ]) ?>

</div>
