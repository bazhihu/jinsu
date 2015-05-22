<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = '修改订单';

?>
<div class="order-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'orderPatientModel' => $orderPatientModel,
        'action' => Yii::$app->urlManager->createUrl(['order/update', 'id'=>$model->order_id])
    ]) ?>

</div>
