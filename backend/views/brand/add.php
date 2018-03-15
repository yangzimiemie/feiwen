<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($brand,'name');
echo $from->field($brand,'sort');
echo $from->field($brand,'status')->inline()->radioList([1=>'禁用',2=>'开启'],['value'=>2]);
echo $from->field($brand,'detail')->textarea();
echo $from->field($brand,'img')->fileInput();
echo $from->field($brand,'code')->widget(yii\captcha\Captcha::className(),['captchaAction' => 'brand/code','template' => '<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'
]);
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();