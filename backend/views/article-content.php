<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ArticleContent */
/* @var $form ActiveForm */
?>
<div class="article-content">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content') ?>
        <?= $form->field($model, 'article_id') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-content -->
