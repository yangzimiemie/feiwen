<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-responsive"
    <tr>
        <td>文章Id</td>
        <td>文章名</td>
        <td>文章排序</td>
        <td>文章简介</td>
        <td>文章标题</td>
        <td>分类名</td>
        <td>文章状态</td>
        <td>录入时间</td>
        <td>更新时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($article  as $row):?>

        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->sort?></td>
            <td><?=$row->detail?></td>
            <td><?=$row->title?></td>
            <td><?=$row->category->name?></td>
            <td><?php
                if($row->status){
                    ?>
                    <i class="btn btn-success glyphicon glyphicon-ok"></i>
                    <?php
                }else{
                    echo  '<a class="btn btn-danger glyphicon glyphicon-remove"></a>';
                }
                ?>
            </td>
            <td><?=date("Y-m-d:H:i:s,$row->create_time")?></td>
            <td><?=date("Y-m-d:H:i:s,$row->update_time")?></td>
            <td>
                <a href="<?=yii\helpers\Url::to(['edit','id'=>$row->id])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$row->id])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<!--分页-->
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pages,
])?>