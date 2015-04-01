<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Workerother $model
 */

$this->title = 'Update Workerother: ' . ' ' . (int)$_GET['worker_id'];
$this->params['breadcrumbs'][] = ['label' => 'Workerothers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (int)$_GET['worker_id'], 'url' => ['view', 'worker_id' => (int)$_GET['worker_id']]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>