<?php
/* @var $this yii\web\View */
/* @var \vintage\search\models\SearchResult[] $result */
//$result = Yii::$app->get('searcher')->search('some query here');
?>
    <h1>商品列表</h1>
<div>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus pull-left"> </a>
    <form class="form-inline pull-right">
        <select class="form-control" name="status">
            <option>请选择商品状态</option>
            <option value="0" <?=yii::$app->request->get('status')==="0"?"selected":""?>>已禁用</option>
            <option value="1" <?=yii::$app->request->get('status')==="1"?"selected":""?>>已激活</option>
        </select>
        <div class="form-group">
            <label for="exampleInputName2"></label>
            <input type="text" class="form-control" id="exampleInputName2" placeholder="最低价" name="minPrice" size="6" value="<?=yii::$app->request->get('minPrice')?>">
        </div>
        -
        <div class="form-group">
            <label for="exampleInputName2"></label>
            <input type="text" class="form-control" id="exampleInputName2" placeholder="最高价" name="maxPrice" size="6" value="<?=yii::$app->request->get('maxPrice')?>">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail2"></label>
            <input type="text" class="form-control" id="exampleInputEmail2" placeholder="名称或货号" name="keyWord" value="<?=yii::$app->request->get('keyWord')?>">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
    </form>
</div>

    <table class="table table-responsive"
    <tr>
        <td>商品名</td>
        <td>商品排序</td>
        <td>商品货号</td>
        <td>商品价格</td>
        <td>商品品牌</td>
        <td>商品logo</td>
        <td>商品库存</td>
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
        <td><?=$row->brandName->name?></td>
        <td>
            <?php
            $imgFile =strpos($row->logo,'ttp://')?$row->logo:"/".$row->logo;
            echo \yii\bootstrap\Html::img($imgFile,['height'=>30]);
            ?>
        </td>
        <td><?=$row->stock?></td>
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

