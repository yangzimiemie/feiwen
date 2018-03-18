<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($article,'name');
echo $from->field($article,'sort');
echo $from->field($article,'status')->inline()->radioList(['禁用','开启'],['value'=>1]);
echo $from->field($article,'detail')->textarea();
echo $from->field($article,'code')->widget(yii\captcha\Captcha::className(),['captchaAction' => 'article/code','template' => '<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'
]);
echo $from->field($article,'title');
echo $from->field($content,'text')->widget('kucha\ueditor\UEditor',[]);
echo $from->field($article,'category_id')->dropDownList($oneArr);
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();