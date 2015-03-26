<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\HospitalDepartmentRelation $model
 */

$this->title = 'Update Hospital Department Relation: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hospital Department Relations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hospital-department-relation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
