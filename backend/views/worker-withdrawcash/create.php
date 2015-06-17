<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use kartik\detail\DetailView;


/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */

$this->title = '护工提现申请';
?>
<div class="worker-withdrawcash-create">

    <div class="panel panel-info" style="margin: 50px 30% 0 30%">
        <div class="panel-heading">
            <h1 class="panel-title" id="panel-title"><?= Html::encode($this->title) ?><a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h1>
        </div>
        <?php if($model){ ?>
        <div class="panel-body">
            <label><big>基本信息</big></label><br/>
            <?php
            echo DetailView::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'attributes'=>[
                    [
                        'attribute'=>'worker_name',
                        'value'=>$model->worker_name,
                    ],
                    [
                        'attribute'=>'identity_card',
                        'value'=>$model->identity_card,
                    ],
                    [
                        'attribute'=>'bank',
                        'value'=> $model->bank?\backend\models\WorkerCard::$_BANK[$model->bank]:'',
                    ],
                    [
                        'attribute'=>'bank_card',
                        'value'=>$model->bank_card,
                    ],
                    [
                        'attribute'=>'money',
                        'label'=>'余额',
                        'value'=>\backend\models\WorkerAccount::findOne(['worker_id'=>$model->worker_id])?\backend\models\WorkerAccount::findOne(['worker_id'=>$model->worker_id])->balance:0,
                    ],
                ]
            ]);?>

        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
            ?>
            <input type="hidden" name="worker_id" value="<?=$model->worker_id?>"/>
            <?php
            if($balance && $balance->balance){
                echo Html::submitButton(Yii::t('app', '提现'), ['class' => 'btn btn-success btn-lg']);
            } else {
                echo Html::button(Yii::t('app', '提现'), ['class' => 'btn btn-lg']);
            }

            ActiveForm::end(); ?>
        </div>
        <?php }else{?>
            <div class="panel-body">
               <span>暂无工资卡</span>
            </div>
        <?php }?>
    </div>
</div>
