<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 */

$this->title = '编辑用户: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="panel panel-info col-xs-8">
    <div class="panel-heading">
        <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
        <div class="admin-user-update">

            <h1><?= Html::encode($this->title) ?></h1>
            <?= $this->render('_form2', [
                'model' => $model,
                'staff_role'=>$staff_role,
            ]) ?>

        </div>
    </div>
</div>

