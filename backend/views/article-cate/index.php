<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>

<table class="table table-responsive"
    <tr>
        <td>文章分类Id</td>
        <td>文章分类名</td>
        <td>文章分类排序</td>
        <td>文章分类简介</td>
        <td>文章分类标题</td>
        <td>帮助类</td>
        <td>文章分类状态</td>
        <td>操作</td>
    </tr>
    <?php foreach ($cate  as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->sort?></td>
            <td><?=$row->detail?></td>
            <td><?=$row->title?></td>
            <td><?php
                if($row->is_help){
                    ?>
                    <i class="btn btn-success glyphicon glyphicon-ok"></i>
                    <?php
                }else{
                    echo  '<a class="btn btn-danger glyphicon glyphicon-remove"></a>';
                }
                ?>
            </td>
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