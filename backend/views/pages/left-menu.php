<?php
use yii\helpers\Url;
$controller = $this->context;
//$menus = $controller->module->menus;
$route = $controller->route;
//print_r($route);exit;

?>
<ul class="nav nav-sidebar">
    <li <?php if($route == 'worker/create'):?>class="active"<?php endif;?>><a href="#">添加护工</a></li>
    <li <?php if($route == 'worker/index'):?>class="active"<?php endif;?>><a href="#">护工管理</a></li>

</ul>

<ul class="nav nav-sidebar">
    <li <?php if($route == 'order/create'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/create');?>">新增订单</a></li>
    <li <?php if($route == 'order/index'):?>class="active"<?php endif;?>><a href="<?=Url::toRoute('order/index');?>">订单管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li><a href="">用户管理</a></li>
</ul>