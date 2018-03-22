<a href="index" class="btn btn-success glyphicon glyphicon-arrow-right col-lg-offset-10"></a>
<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($per,'name')->textInput(['disabled'=>"disabled"]);
echo $from->field($per,'description')->textarea();
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();