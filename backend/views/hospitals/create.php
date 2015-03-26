<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Hospitals $model
 */

$this->title = 'Create Hospitals';
$this->params['breadcrumbs'][] = ['label' => 'Hospitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hospitals-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
