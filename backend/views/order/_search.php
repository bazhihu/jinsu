<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\models\Departments;
use backend\models\OrderMaster;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-ordersearch-create_time{
        float:left;width:210px
    }
    .field-ordersearch-start_time{
        float:left;width:210px
    }
    .field-ordersearch-end_time{
        float:left;width:210px
    }
    .field-ordersearch-reality_end_time{
        float:left;width:210px
    }
</style>
<div class="order-master-search">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">检索</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'type' => ActiveForm::TYPE_VERTICAL,
                'formConfig' => [
                    'showLabels' => true,
                ],
            ]); ?>

            <?php
            echo $form->field($model, 'create_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ])->label('下单时间');
            ?>

            <?php
            echo $form->field($model, 'start_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ])->label('开始时间');
            ?>

            <?php
            echo $form->field($model, 'end_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ])->label('结束时间');
            ?>

            <?php
            echo $form->field($model, 'reality_end_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ]);
            ?>

            <?php
//            echo $form->field($model, 'department_id')
//                ->widget(\kartik\widgets\Select2::classname(),[
//                    'data' => Departments::getList(),
//                    'options' => ['placeholder' => '请选择','style'=>'width:200px'],
//                    'pluginOptions' => [
//                        'allowClear' => true
//                    ],
//                ]);
            ?>
            <?php
//            echo $form->field($model, 'order_status')
//                ->dropDownList(OrderMaster::$orderStatusLabels,['prompt'=>'请选择']);
            ?>
            <?= $form->field($model, 'customer_service_id')->widget(\kartik\widgets\Select2::classname(),[
                'data' => \backend\models\AdminUser::getService(),
                'options' => ['placeholder' => '请选择','style'=>'width:110px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('客服');?>

            <?= $form->field($model, 'create_order_sources')
                ->dropDownList(OrderMaster::$orderSources,['prompt'=>'请选择'])
                ->label('订单来源');
            ?>



            <div class="form-group" style="margin-top: 30px">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
