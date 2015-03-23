<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WalletUser */

$this->title = 'Create Wallet User';
$this->params['breadcrumbs'][] = ['label' => 'Wallet Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
