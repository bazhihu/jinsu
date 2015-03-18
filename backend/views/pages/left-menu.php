<?php
use yii\helpers\Url;
?>
<ul class="nav nav-sidebar">
    <li><a href="#">添加护工</a></li>
    <li class="active"><a href="#">护工管理</a></li>

</ul>

<ul class="nav nav-sidebar">
    <li><a href="<?=Url::toRoute('order/create');?>">新增订单</a></li>
    <li><a href="<?=Url::toRoute('order/index');?>">订单管理</a></li>
</ul>

<ul class="nav nav-sidebar">
    <li><a href="">用户管理</a></li>
</ul>