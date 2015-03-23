<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wallet Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wallet User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'uid',
            'money',
            'money_pay',
            'money_pay_s',
            'money_consumption',
            // 'money_extract',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
