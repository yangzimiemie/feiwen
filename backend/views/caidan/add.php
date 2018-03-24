<a href="index" class="btn btn-success glyphicon glyphicon-arrow-right col-lg-offset-10"></a>
<?php
$from = \yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name');
echo $from->field($model,'icon');
echo $from->field($model,'url')->textarea();
echo $from->field($model, 'parent_id');
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();