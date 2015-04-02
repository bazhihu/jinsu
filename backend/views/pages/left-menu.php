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
    <li <?php if($route == 'user/create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('user/create');?>">用户注册</a></li>
    <li <?php if($route == 'user/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('user/index');?>">用户管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'wallet/recharge-records'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet/recharge-records');?>">充值记录</a></li>
    <li <?php if($route == 'wallet/cash-list'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet/cash-list');?>">提现申请</a></li>
    <li <?php if($route == 'wallet/confirm-list'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet/confirm-list');?>">提现支付</a></li>
    <li <?php if($route == 'wallet/cash-records'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet/cash-records');?>">提现记录</a></li>
    <li <?php if($route == 'wallet/debit-records'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('wallet/debit-records');?>">扣款明细</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'comment/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('comment/index');?>">评价管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'admin-user/create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('admin-user/create');?>">新增账号</a></li>
    <li <?php if($route == 'admin-user/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('admin-user/index');?>">帐号列表</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'hospitals/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('hospitals/index');?>">医院管理</a></li>
    <li <?php if($route == 'departments/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('departments/index');?>">科室管理</a></li>
</ul>

