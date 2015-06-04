<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WorkerAccount */

$this->title = 'Create Worker Account';
$this->params['breadcrumbs'][] = ['label' => 'Worker Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
