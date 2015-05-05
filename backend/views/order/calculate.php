<?php
$details = $model->calculateTotalPrice(true);
?>
<table class="detail-view table table-hover table-bordered table-striped">
    <thead>
    <tr>
        <th>日期</th>
        <th>每天基础价格</th>
        <th>不能自理加价</th>
        <th>节假日加价</th>
        <th>每天总价格</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($details['PriceDetail'] as $date => $item):?>
        <tr>
            <td><div class="kv-attribute"><?php echo $date;?></div></td>
            <td><div class="kv-attribute"><?php echo $item['basePrice'];?></div></td>
            <td><div class="kv-attribute"><?php echo $item['disabledPrice'];?></div></td>
            <td><div class="kv-attribute"><?php echo $item['holidayPrice'];?></div></td>

            <td><div class="kv-attribute"><?php echo $item['dayPrice'];?></div></td>
        </tr>
    <?php endforeach;?>
    <tr class="warning">
        <td><h4>总额（元）</h4></td>
        <td colspan="4" style="text-align: right">
            <h4><span class="label label-danger"><?php echo $details['totalPrice'];?></span></h4>
        </td>
    </tr>
    </tbody>
</table>