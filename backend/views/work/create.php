<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\Models\Work */

$this->title = '创建工单';
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'orderInfo'=>$orderInfo
    ]) ?>

</div>
