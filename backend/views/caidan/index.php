<?php
/* @var $this yii\web\View */
?>
<h1>菜单列表</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-bordered">
    <tr>
        <td>名称</td>
        <td>图标</td>
        <td>地址</td>
        <td>操作</td>
    </tr>
    <?php foreach ($model as $row):?>
    <tr>
        <td><?=$row->name?></td>
        <td><?=$row->icon?></td>
        <td><?=$row->url?></td>
        <td>
            <a href="<?=yii\helpers\Url::to(['edit','id'=>$row->id])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
            <a href="<?=yii\helpers\Url::to(['del','id'=>$row->id])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
        </td>
    </tr>

    <?php endforeach;?>
</table>