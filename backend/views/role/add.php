<a href="index" class="btn btn-success glyphicon glyphicon-arrow-right col-lg-offset-10"></a>
<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($role,'name');
echo $from->field($role,'description')->textarea();
echo $from->field($role,'permission')->inline()->checkboxList($persArr);
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();