<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$this->title = '新增请假信息';
?>
<style>
    .admin-user-form{
        padding: 0 15% 0 0;
    }
</style>
<div class="panel panel-info" style="margin: 8%;">
    <div class="panel-body">
        <div class="admin-user-create">
            <div class="page-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="admin-user-form">
<?php
    $form = ActiveForm::begin([
            'type'=>ActiveForm::TYPE_HORIZONTAL]
    );
    echo Form::widget([
        'model'         => $model,
        'form'          => $form,
        'columns'       => 1,
        'attributes'    => [
            'worker_id'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>[
                    'placeholder'=>'请输入护工工号...',
                    'maxlength'=>255,
                ]
            ],
            'worker_name'=>[
                'type'=> Form::INPUT_TEXT,
                'options'=>[
                    'placeholder'=>'请输入护工姓名...',
                    'maxlength'=>255,
                ]
            ],
            'start_time'=>[
                'type'=>Form::INPUT_WIDGET,
                'widgetClass'=>'\kartik\widgets\DateTimePicker',
                'options'=>[
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ]
            ],
            'end_time'=>[
                'type'=>Form::INPUT_WIDGET,
                'widgetClass'=>'\kartik\widgets\DateTimePicker',
                'options'=>[
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ]
            ],
            'leave_cause'=>[
                'type'=> Form::INPUT_TEXTAREA,
                'options'=>[
                    'placeholder'=>'请输入请假原因...',
                    'maxlength'=>255
                ]
            ],
        ]
    ]);
    ?>
<?php
echo Html::submitButton( '提交', ['class' => 'btn btn-lg btn-success jsSubmitCreate']);
ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>