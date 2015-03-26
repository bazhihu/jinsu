<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\HospitalDepartmentRelation $model
 */

$this->title = 'Create Hospital Department Relation';
$this->params['breadcrumbs'][] = ['label' => 'Hospital Department Relations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hospital-department-relation-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
