<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUser */

$this->title = 'Update Wallet User: ' . ' ' . $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Wallet Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wallet-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
