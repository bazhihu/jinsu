<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\User $model
 */

$this->title = '编辑用户: ' . ' ' . substr_replace($model->mobile,'****',3,4);
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
