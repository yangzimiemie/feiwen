<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($cate,'name');
echo $from->field($cate,'sort');
echo $from->field($cate,'status')->inline()->radioList(['禁用','开启'],['value'=>1]);
echo $from->field($cate,'detail')->textarea();
echo $from->field($cate,'code')->widget(yii\captcha\Captcha::className(),['captchaAction' => 'article-cate/code','template' => '<div class="row"><div class="col-lg-1">{image}</div><div class="col-lg-1">{input}</div></div>'
]);
echo $from->field($cate,'title');
echo $from->field($cate,'is_help')->inline()->radioList(['否','是'],['value'=>1]);
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();