<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */
$this->title = '账号充值 用户ID：'.$userRow['uid'];
$this->params['breadcrumbs'][] = ['label' => 'Wallet User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userRow' => $userRow,
    ]) ?>

</div>
