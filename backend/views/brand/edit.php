<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($brand,'name');
echo $from->field($brand,'img')->fileInput();
echo $from->field($brand,'sort');
echo $from->field($brand,'status')->radioList([1=>'禁用',2=>'启用'],['value'=>2]);
echo $from->field($brand,'detail')->textarea();
echo \yii\helpers\Html::submitButton('修改');
\yii\bootstrap\ActiveForm::end();