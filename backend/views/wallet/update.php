<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */

$this->title = 'Update Wallet User Detail: ' . ' ' . $model->detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Wallet User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->detail_id, 'url' => ['view', 'id' => $model->detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wallet-user-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
