<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '关于我们';
?>
<style>
    .line {border-top: 4px solid #2dcb9c; overflow: hidden; -webkit-background-size: cover; background-size: cover; }
    .express p{
        color: #334559;
        font-size: 20px;
        font-weight: 400;
        line-height: 32px;
    }
    h1{margin-bottom:10px}
</style>
<div class="line"></div>
<div class="express section clearfix">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        北京首卫康勤医院管理有限公司成立于2013年9月，现有员工近4000人公司主要从事专业医疗机构综合服务，先后与多家医院、医疗机构建立了良好的业务合作关系。公司坚持以客户需求为导向，提供“贴现式、标准化”专业服务，服务项目包括各层级医护人员、护工管理，内容涉及康复护理、机构养老和居家养老等服务，满足了客户个性化需求。
        公司致力于为有志服务广大民众健康的爱心人士搭建平台，注重打造优秀团队。公司有严格的员工准入标准，规范的入职教育和岗前培训体系。坚持积极塑造健康专业的员工形象；坚持服务管理标准化、规范化、精细化、力做同行领头羊。
        2015年，公司引进社会资金，拓展全国业务，向大健康产业延伸，公司以北京为中心，辐射全国为发展目标。目前业务范围正向上海、浙江、江苏、广东、辽宁、成都等城市发展。
    </p>
</div>
