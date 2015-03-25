<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Holidays $model
 */

$this->title = '添加节假日日期';
//$this->params['breadcrumbs'][] = ['label' => 'Holidays', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holidays-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
