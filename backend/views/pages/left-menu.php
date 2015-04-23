<?php
use yii\helpers\Url;
$controller = $this->context;
//$menus = $controller->module->menus;
$route = $controller->route;
//print_r($route);exit;

?>
<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/worker/create')):?>hide <?php endif;?><?php if($route == 'worker/create'):?>active<?php endif;?>"><a href="<?=Url::toRoute('worker/create');?>">添加护工</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/worker/index')):?>hide <?php endif;?><?php if($route == 'worker/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('worker/index');?>">护工管理</a></li>

</ul>

<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/order/create')):?>hide <?php endif;?><?php if($route == 'order/create'):?>active<?php endif;?>"><a href="<?=Url::toRoute('order/create');?>">新增订单</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/order/index')):?>hide <?php endif;?><?php if($route == 'order/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('order/index');?>">订单管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/user/index')):?>hide <?php endif;?><?php if($route == 'user/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('user/index');?>">用户管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/wallet/recharge-records')):?>hide <?php endif;?><?php if($route == 'wallet/recharge-records'):?>active<?php endif;?>"><a href="<?=Url::toRoute('wallet/recharge-records');?>">充值记录</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/wallet/cash-list')):?>hide <?php endif;?><?php if($route == 'wallet/cash-list'):?>active<?php endif;?>"><a href="<?=Url::toRoute('wallet/cash-list');?>">提现申请</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/wallet/confirm-list')):?>hide <?php endif;?><?php if($route == 'wallet/confirm-list'):?>active<?php endif;?>"><a href="<?=Url::toRoute('wallet/confirm-list');?>">提现支付</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/wallet/cash-records')):?>hide <?php endif;?><?php if($route == 'wallet/cash-records'):?>active<?php endif;?>"><a href="<?=Url::toRoute('wallet/cash-records');?>">提现记录</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/wallet/debit-records')):?>hide <?php endif;?><?php if($route == 'wallet/debit-records'):?>active<?php endif;?>"><a href="<?=Url::toRoute('wallet/debit-records');?>">交易明细</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/comment/index')):?>hide <?php endif;?><?php if($route == 'comment/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('comment/index');?>">评价管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/admin-user/create')):?>hide <?php endif;?><?php if($route == 'admin-user/create'):?>active<?php endif;?>"><a href="<?=Url::toRoute('admin-user/create');?>">新增账号</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/admin-user/index')):?>hide <?php endif;?><?php if($route == 'admin-user/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('admin-user/index');?>">帐号列表</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/hospitals/index')):?>hide <?php endif;?><?php if($route == 'hospitals/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('hospitals/index');?>">医院管理</a></li>
    <li class="<?php if(!\backend\models\AdminUser::checkPermissions('/departments/index')):?>hide <?php endif;?><?php if($route == 'departments/index'):?>active<?php endif;?>"><a href="<?=Url::toRoute('departments/index');?>">科室管理</a></li>
</ul>

