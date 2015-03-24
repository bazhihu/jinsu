<?php
use yii\helpers\Url;
$controller = $this->context;
//$menus = $controller->module->menus;
$route = $controller->route;
//print_r($route);exit;

?>
<ul class="nav nav-sidebar">
    <li <?php if($route == 'worker/create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('worker/create');?>">添加护工</a></li>
    <li <?php if($route == 'worker/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('worker/index');?>">护工管理</a></li>

</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'order/create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/create');?>">新增订单</a></li>
    <li <?php if($route == 'order/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/index');?>">订单管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li><a href="">用户管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li><a href="">财务管理</a></li>
    <li <?php if($route == 'wallet-user-detail/pay-create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute(['wallet-user-detail/pay-create', 'uid' => '2']);?>">充值</a></li>
    <li <?php if($route == 'wallet-user-detail/pay-index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet-user-detail/pay-index');?>">充值记录</a></li>
    <li <?php if($route == 'withdrawcash/apply'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/index');?>">提现申请</a></li>
    <li <?php if($route == 'withdrawcash/payment'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/create');?>">提现支付</a></li>
    <li <?php if($route == 'withdrawcash/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/create');?>">提现记录</a></li>
    <li <?php if($route == 'wallet-user-detail/deduction_index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet-user-detail/deduction_index');?>">扣款明细</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'admin-user/create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('admin-user/create');?>">新增账号</a></li>
    <li <?php if($route == 'admin-user/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('admin-user/index');?>">帐号列表</a></li>
</ul>