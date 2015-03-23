<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */

$this->title = 'Create Wallet User Detail';
$this->params['breadcrumbs'][] = ['label' => 'Wallet User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
