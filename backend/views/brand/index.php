<a href="<?=\yii\helpers\Url::to(['brand/add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>

<table class="table table-responsive">
    <tr>
        <td>品牌Id</td>
        <td>品牌名</td>
        <td>品牌logo</td>
        <td>品牌排序</td>
        <td>品牌状态</td>
        <td>品牌简介</td>
        <td>删除状态</td>
        <td>操作</td>
    </tr>
    <?php foreach ($brand as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td>
           <?php
           $imgFile =strpos($row->logo,'ttp://')?$row->logo:"/".$row->logo;
           echo \yii\bootstrap\Html::img($imgFile,['height'=>30]);
           ?>
        </td>

        <td><?=$row->sort?></td>
        <td><?php
            if($row->status){
            ?>
            <i class="btn btn-success glyphicon glyphicon-ok"></i>
            <?php
            }else{
              echo  '<a class="btn btn-danger glyphicon glyphicon-remove"></a>';
            }
            ?></td>
        <td><?=$row->detail?></td>
        <td><?php
            if($row->recycle){
                ?>
                <i class="btn btn-success glyphicon glyphicon-ok" ></i>
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
    'pagination' => $page,
])?>