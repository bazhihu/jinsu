<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wallet User Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wallet User Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'detail_id',
            'detail_id_no',
            'order_id',
            'order_no',
            'worker_id',
            // 'uid',
            // 'detail_money',
            // 'detail_type',
            // 'wallet_money',
            // 'detail_time',
            // 'remark',
            // 'pay_from',
            // 'extract_to',
            // 'admin_uid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
