<a href="<?=\yii\helpers\Url::to(['brand/add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-responsive">
    <tr>
        <td>品牌Id</td>
        <td>品牌名</td>
        <td>品牌logo</td>
        <td>品牌排序</td>
        <td>品牌状态</td>
        <td>品牌简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($brand as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><img src="/<?=$row->logo?>" height="30"></td>
        <td><?=$row->sort?></td>
        <td><?=$row->status?></td>
        <td><?=$row->detail?></td>
        <td>
            <a href="<?=yii\helpers\Url::to(['edit','id'=>$row->id])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
            <a href="<?=yii\helpers\Url::to(['del','id'=>$row->id])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pages,

])?>