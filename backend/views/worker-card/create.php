<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$this->title = '新增银行卡';
?>
<style>
    .admin-user-form{
        padding: 0 15% 0 0;
    }
</style>
<div class="panel panel-info" style="margin: 8%;">
    <div class="panel-body">
        <div class="worker-leave-list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">护工信息</h3>
                </div>
                <div class="panel-body">
                    <span class="btn-lg">姓名：<?=$worker->name?></span>
                    <span class="btn-lg">工号：<?=$worker->worker_id?></span>
                    <span class="btn-lg">开户行：中国工商银行</span>
                </div>
            </div>
        </div>
        <div class="worker-leave-list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">新增银行卡</h3>
                </div>
                <div class="panel-body">
                    <div class="worker-card-create">
                        <div class="worker-card-form">
                            <?php
                            $form = ActiveForm::begin([
                                    'type'=>ActiveForm::TYPE_HORIZONTAL]
                            );
                            echo Form::widget([
                                'model'         => $model,
                                'form'          => $form,
                                'columns'       => 1,
                                'attributes'    => [
                                    /*'bank'=>[
                                        'type'=> Form::INPUT_DROPDOWN_LIST,
                                        'items'=>\backend\models\WorkerCard::$_BANK,
                                        'options'=>[
                                            'prompt'=>'选择'
                                        ]
                                    ],*/
                                    'bank_card'=>[
                                        'type'=> Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>'请输入银行卡号...',
                                            'maxlength'=>255,
                                        ]
                                    ],
                                    'bank_sub_account'=>[
                                        'type'=> Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>'请输入子账户...',
                                            'maxlength'=>255,
                                        ]
                                    ],
                                ]
                            ]);
                            ?>
                            <input type="hidden" id="workercard-bank" class="form-control" name="WorkerCard[bank]" value="ICBC">
                            <input type="hidden" id="workercard-worker_id" class="form-control" name="WorkerCard[worker_id]" value="<?=$worker->worker_id?>">
                            <input type="hidden" id="workercard-worker_name" class="form-control" name="WorkerCard[worker_name]" value="<?=$worker->name?>">
                            <input type="hidden" id="workercard-identity_card" class="form-control" name="WorkerCard[identity_card]" value="<?=$worker->idcard?>">
                            <?php
                            echo Html::submitButton( '提交', ['class' => 'btn btn-lg btn-success jsSubmitCreate']);
                            ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>