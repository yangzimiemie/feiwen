<?php
/* @var $this yii\web\View */
/* @var \vintage\search\models\SearchResult[] $result */
//$result = Yii::$app->get('searcher')->search('some query here');
?>
    <h1>商品列表</h1>
<div>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"> </a>
    <input type="text" class="glyphicon-search col-lg-offset-8"/>
</div>

    <table class="table table-responsive"
    <tr>
        <td>商品名</td>
        <td>商品排序</td>
        <td>商品货号</td>
        <td>商品价格</td>
        <td>商品品牌</td>
        <td>商品logo</td>
        <td>商品分类名</td>
        <td>商品状态</td>
        <td>操作</td>
    </tr>
<?php foreach ($goods  as $row):?>

    <tr>
        <td><?=$row->name?></td>
        <td><?=$row->sort?></td>
        <td><?=$row->sn?></td>
        <td><?=$row->price?></td>
        <td><?=$row->brand?></td>
        <td>
            <?php
            $imgFile =strpos($row->logo,'ttp://')?$row->logo:"/".$row->logo;
            echo \yii\bootstrap\Html::img($imgFile,['height'=>30]);
            ?>
        </td>
        <td><?=$row->goodsCate->name?></td>
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
    <!--分页-->
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pages,
])?>

