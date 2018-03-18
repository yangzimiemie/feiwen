<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($brand,'name');
echo $from->field($brand,'sort');
echo $from->field($brand,'status')->inline()->radioList(['禁用','开启'],['value'=>1]);
echo $from->field($brand,'recycle')->inline()->radioList(['已删除','未删除'],['value'=>1]);
echo $from->field($brand,'detail')->textarea();
echo $from->field($brand, 'logo')->widget('manks\FileInput', [
]);
echo $from->field($brand,'code')->widget(yii\captcha\Captcha::className(),['captchaAction' => 'brand/code','template' => '<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'
]);
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();