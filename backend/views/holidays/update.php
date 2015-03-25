<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Holidays $model
 */

$this->title = 'Update Holidays: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Holidays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="holidays-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
