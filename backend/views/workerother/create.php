<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\Models\Workerother $model
 */

$this->title = 'Create Workerother';
$this->params['breadcrumbs'][] = ['label' => 'Workerothers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workerother-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
