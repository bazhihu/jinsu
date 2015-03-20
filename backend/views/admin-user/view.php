<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            //'admin_uid',
            'username',
            ['label'=>'密码','value'=>'******'],
            'staff_role',
            ['label'=>'状态','value'=>$model->status?'正常':'关闭'],
            'created_at',
            //'updated_at',
            'created_id',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
            'confirm'=>Yii::t('app', '确定要操作这个用户的权限？'),
            'method'=>'post',
            ],
        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
