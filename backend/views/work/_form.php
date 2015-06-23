<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Hospitals;
use backend\models\City;
use backend\models\Departments;
use common\models\Order;

/* @var $this yii\web\View */
/* @var $model backend\Models\Work */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    div.required label:before {
        content: " *";
        color: #ff0000;
    }
    red{color: #ff0000;}
    .btn{margin:5px}
    form{margin-bottom: 15px}
    .form-group{margin-bottom: 5px}
</style>
<div class="order-master-form">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">订单信息</h3>
                </div>
                <div class="panel-body">
                    <table>
                        <tr>
                            <td height="35"><b>订单编号：</b><?=$orderInfo['order_no']?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>员工号：</b><?=$orderInfo['worker_no']?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>员工姓名：</b><?=$orderInfo['worker_name']?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>订单价格：</b><?=$orderInfo['total_amount']?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>订单时间：</b><?=$orderInfo['start_time']."--".$orderInfo['reality_end_time']?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>订单周期：</b><?=Order::getOrderCycle($orderInfo['start_time'],$orderInfo['reality_end_time'])?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>服务城市：</b><?=City::getCityName($orderInfo['city_id'])?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>服务医院：</b><?=Hospitals::getHospitalsName($orderInfo['hospital_id'])?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>科室：</b><?=Departments::getDepartmentNames($orderInfo['department_id'])?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>联系人：</b><?=($orderInfo['contact_name'])?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>账号：</b><?=($orderInfo['mobile'])?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">投诉信息</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 11]) ?>

                    <?= $form->field($model, 'user_name')->textInput(['maxlength' => 20]) ?>

                    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? '创建' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php ActiveForm::end(); ?>

</div>