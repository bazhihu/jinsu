<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 */

$this->title = '添加评价';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>