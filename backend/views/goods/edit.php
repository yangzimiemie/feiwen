<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($goods,'name');
echo $from->field($goods,'sort');
echo $from->field($goods,'sn')->textInput(['value'=>date("Ymd".'0'.$conts)]);
echo $from->field($goods,'price');
echo $from->field($goods,'brand_id')->dropDownList($brandArr,["prompt"=>"请选择品牌"]);
echo $from->field($goods, 'logo')->widget('manks\FileInput', [
]);
echo $from->field($goods, 'images')->widget('manks\FileInput', [
    'clientOptions' => [
        'pick' => [
            'multiple' => true,
        ],
        // 'server' => Url::to('upload/u2'),
        // 'accept' => [
        // 	'extensions' => 'png',
        // ],
    ],
]);
echo $from->field($goods,'status')->inline()->radioList(['禁用','开启'],['value'=>1]);
echo $from->field($details,'details')->widget('kucha\ueditor\UEditor',[]);
echo $from->field($goods,'goods_cate_id')->dropDownList($catesArr,["prompt"=>"请选择分类"]);
echo \yii\helpers\Html::submitButton('修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>
<a href="index" class="btn btn-success glyphicon glyphicon-arrow-right col-lg-offset-10"></a>
