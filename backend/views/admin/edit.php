<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($admin,'username');;
echo $from->field($admin,'password_hash')->passwordInput(['value'=>""]);
echo $from->field($admin,'status')->inline()->radioList(['禁用',10=>'开启']);
echo $from->field($admin,'email');
echo $from->field($admin, 'logo')->widget('manks\FileInput', [
]);
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
