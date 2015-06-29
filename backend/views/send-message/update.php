<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SendMessage */

$this->title = 'Update Send Message: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Send Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="send-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
