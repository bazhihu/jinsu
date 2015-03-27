<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */

$this->title = $model->detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Wallet User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->detail_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'detail_id',
            'detail_no',
            'order_id',
            'order_no',
            'worker_id',
            'uid',
            'detail_money',
            'detail_type',
            'wallet_money',
            'detail_time',
            'remark',
            'pay_from',
            'extract_to',
            'admin_uid',
        ],
    ]) ?>

</div>
