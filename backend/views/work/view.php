<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\City;
use common\models\Order;
use backend\models\Hospitals;
use backend\models\Departments;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\Models\Work */

$this->title = $model->work_id."工单详情";
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="order-master-form">
        <div class="row">
            <div class="col-sm-4">
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
                                <td height="35"><b>订单价格：</b><?=$orderInfo['real_amount']?></td>
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
            <div class="col-sm-4" >
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">投诉信息</h3>
                    </div>
                    <div class="panel-body" style="height: 416px">
                        <table>
                            <tr>
                                <td height="35"><b>联系电话：</b><?=$model['mobile']?></td>
                            </tr>
                            <tr>
                                <td height="35"><b>姓名：</b><?=$model['user_name']?></td>
                            </tr>
                            <tr>
                                <td height="35"><b>投诉渠道：</b><?=$model['from_where']?></td>
                            </tr>


                            <tr>
                                <td height="35"><b>内容：</b><?=$model['content']?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" >
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">解决信息</h3>
                    </div>
                    <div class="panel-body" style="height: 416px">
                        <?php $form = ActiveForm::begin(); ?>
                        <?
                        echo $form->field($model, 'type')->widget(Select2::classname(), [
                        'data' => ['1'=>'1','2'=>'2'],
                        'options' => ['placeholder' => '请选择类型','style'=>'width:30%'],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                        ])->label('类型');
                        ?>
                        <?= $form->field($model, 'solver_content')->textarea(['rows' => 6]) ?>
                        <tr>
                            <td height="35"><b>状态：</b><? if($model['status']==1) echo "未解决"; if($model['status']==2) echo "已解决";if($model['status']==3) echo "关闭";?></td>
                        </tr>
                        <tr>
                            <td height="35"><b>解决时间：</b><?=$model['solve_date']?></td>
                        </tr>
                        <div class="form-group">
                            <?= Html::submitButton('解决', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>