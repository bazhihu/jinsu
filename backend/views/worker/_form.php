<?php

use yii\helpers\Html;
use yii\helpers\Url;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;


/**
 * @var yii\web\View $this
 * @var backend\Models\Worker $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="worker-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

        'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 姓名...', 'maxlength'=>20,'style'=>'width:50%']],

        'gender'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 性别...'], 'items'=>['1'=>'男','2'=>'女'], 'options'=>['inline'=>true]],

        'birth'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
            'options'=>[
                'type'=>DateControl::FORMAT_DATE,
                'displayFormat' => 'yyyy-MM-dd',
                'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
            ],
        ],



       /* 'native_province'=>[
                'type'=> Form::INPUT_WIDGET,'widgetClass'=>Select2::classname(),
                'options'=>['placeholder'=>'Enter 籍贯...', 'maxlength'=>50,'data' => \backend\models\Hospitals::getList()],
                'pluginOptions' => ['allowClear' => true]
        ],*/

        'marriage'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 婚姻状况...'], 'items'=>['1'=>'已婚','2'=>'未婚'], 'options'=>['inline'=>true]],

        'education'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 文化程度...'], 'items'=>['1'=>'男','2'=>'女'], 'options'=>['inline'=>true]],

        'politics'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 政治面貌...'], 'items'=>['1'=>'群众','2'=>'团员','3'=>'中共党员','4'=>'民主党派','5'=>'无党派人士','6'=>'其他'], 'options'=>['inline'=>true]],

        'idcard'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 身份证号...', 'maxlength'=>20,'style'=>'width:50%']],

        'chinese_level'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 普通话水平...'], 'items'=>['1'=>'一般','2'=>'良好','3'=>'熟练'], 'options'=>['inline'=>true]],

        'certificate'=>['type'=> Form::INPUT_CHECKBOX_LIST, 'options'=>['placeholder'=>'Enter 资质证书...'],'items'=>['1'=>'健康证','2'=>'护理证','3'=>'暂住证'], 'options'=>['inline'=>true], 'maxlength'=>10],

        'phone1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 手机号1...', 'maxlength'=>12,'style'=>'width:50%']],

        'phone2'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 手机号2...', 'maxlength'=>11,'style'=>'width:50%']],

        'level'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 护工等级...'],'items'=>['1'=>'中级','2'=>'高级','3'=>'特级'], 'options'=>['inline'=>true]],

        'price'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 服务价格...','style'=>'width:50%']],

        'status'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=>['placeholder'=>'Enter 工作状态...'],'items'=>['1'=>'在职','2'=>'离职'], 'options'=>['inline'=>true]],

        'start_work'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),
            'options'=>['type'=>DateControl::FORMAT_DATE,'displayFormat' => 'yyyy-MM-dd',
            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true]
            ],
        ]]
    ]);

    //民族
    $nation = array (
        '汉族','壮族','满族','回族','苗族','维吾尔族','土家族',
        '彝族','蒙古族','藏族','布依族','侗族','瑶族','朝鲜族',
        '白族','哈尼族','哈萨克族','黎族','傣族','畲族','傈僳族',
        '仡佬族','东乡族','高山族','拉祜族','水族','佤族','纳西族',
        '羌族','土族','仫佬族','锡伯族','柯尔克孜族','达斡尔族','景颇族',
        '毛南族','撒拉族','布朗族','塔吉克族','阿昌族','普米族','鄂温克族',
        '怒族','京族','基诺族','德昂族','保安族','俄罗斯族','裕固族',
        '乌兹别克族','门巴族','鄂伦春族','独龙族','塔塔尔族','赫哲族','珞巴族'
    );

    echo $form->field($model, 'nation')->widget(Select2::classname(), [
        'data' =>$nation,
        'options' => ['placeholder' => '请选择民族','style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('民族');

    //户口所在地
    /*echo $form->field($model, 'birth_place_province')->dropDownList( \backend\models\City::getList(1), ['id'=>'birth_place_province','style'=>'width:30%']);

    // 户口所在地 Child # 1
    echo $form->field($model, 'birth_place_city')->widget(DepDrop::classname(), [
        'options'=>['id'=>'birth_place_city','style'=>'width:30%'],
        'pluginOptions'=>[
            'depends'=>['birth_place_province'],
            'placeholder'=>'Select...',
            'url'=>Url::to(['/worker/getcity'])
        ]
    ])->label('');

    //户口所在地 Child # 2
    echo $form->field($model, 'birth_place_area')->widget(DepDrop::classname(), [
        'options'=>['style'=>'width:30%'],
        'pluginOptions'=>[
            'depends'=>['birth_place_province', 'birth_place_city'],
            'placeholder'=>'Select...',
            'url'=>Url::to(['/site/subsubcat'])
        ]
    ])->label('');
*/



    //籍贯
    echo $form->field($model, 'native_province')->widget(Select2::classname(), [
        'data' => \backend\models\City::getList(1),
        'options' => ['placeholder' => '请选择籍贯','style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('籍贯');

    // 常驻医院
    echo $form->field($model, 'hospital_id')->widget(Select2::classname(), [
        'data' =>   \backend\models\Hospitals::getList('110000'),
        'addon' => 1,
        'options' => ['placeholder' => '请选择常驻医院','multiple'=>true,'style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumInputLength' => 10
        ],
    ])->label('常驻医院');

    // 常驻科室
    echo $form->field($model, 'office_id')->widget(Select2::classname(), [
        'data' =>   \backend\models\Hospitals::getList('110000'),
        'addon' => 1,
        'options' => ['placeholder' => '请选择常驻科室','multiple'=>true,'style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumInputLength' => 10
        ],
    ])->label('常驻科室');

    // 擅长护理的疾病
    echo $form->field($model, 'good_at')->widget(Select2::classname(), [
        'data' =>   \backend\models\Hospitals::getList('110000'),
        'addon' => 1,
        'options' => ['placeholder' => '请选择擅长护理的疾病','multiple'=>true,'style'=>'width:50%'],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumInputLength' => 10
        ],
    ])->label('擅长护理的疾病');

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
