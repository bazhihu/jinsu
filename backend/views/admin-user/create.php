<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 */

$this->title = '新增帐号';
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-info col-xs-8">
    <div class="panel-heading">
        <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
        <div class="admin-user-create">
            <div class="page-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
                'staff_role'=>$staff_role,
            ]) ?>

        </div>
    </div>
</div>
