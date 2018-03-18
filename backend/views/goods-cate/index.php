<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-condensed">
    <tr>
        <td>id</td>
        <td>分类名</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($cate as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->nameText?></td>
        <td><?=$row->detail?></td>
        <td>
            <a href="<?=yii\helpers\Url::to(['edit','id'=>$row->id])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
            <a href="<?=yii\helpers\Url::to(['del','id'=>$row->id])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
