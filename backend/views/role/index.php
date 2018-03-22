<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-responsive">
    <tr>
        <td>名称</td>
        <td>描述</td>
    </tr>
    <?php foreach ($role as $row):?>
        <tr>
            <td><?=$row->name?></td>
            <td><?=$row->data?></td>
            <td>
                <a href="<?=yii\helpers\Url::to(['edit','name'=>$row->name])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
                <a href="<?=yii\helpers\Url::to(['del','name'=>$row->name])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>