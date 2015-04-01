<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Workerother $model
 */

$this->title = '护工其他信息';
$this->params['breadcrumbs'][] = ['label' => 'Workerothers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>