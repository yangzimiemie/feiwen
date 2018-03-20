<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($brand,'name');
echo $from->field($brand, 'logo')->widget('manks\FileInput', [
]);
echo $from->field($brand,'sort');
echo $from->field($brand,'status')->radioList([1=>'禁用',2=>'启用'],['value'=>2]);
echo $from->field($brand,'recycle')->inline()->radioList([1=>'已删除',2=>'未删除'],['value'=>2]);
echo $from->field($brand,'detail')->textarea();
echo $from->field($brand,'code')->widget(yii\captcha\Captcha::className(),['captchaAction' => 'brand/code','template' => '<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'
]);
echo \yii\helpers\Html::submitButton('修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();