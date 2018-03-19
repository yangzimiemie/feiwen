<?php
/** @var $this \yii\web\View */
?>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-hover">
    <tr>
        <td>分类名</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($cate as $row):?>
    <tr class="cate" data-tree="<?=$row->tree?>" data-lft="<?=$row->lft?>" data-rgt="<?=$row->rgt?>">
        <td><span class="cate-tr btn-info glyphicon glyphicon-triangle-right"></span><?=$row->nameText?></td>
        <td><?=$row->detail?></td>
        <td>
            <a href="<?=yii\helpers\Url::to(['edit','id'=>$row->id])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
            <a href="<?=yii\helpers\Url::to(['del','id'=>$row->id])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//定义js代码
$js=<<<Js
//先找到，添加点击事件
$(".cate-tr").click(function() {
    var parent = $(this).parent().parent();
    var treeParent = parent.attr('data-tree');
    var lftParent = parent.attr('data-lft');
    var rgtParent = parent.attr('data-rgt');
   // console
    $(".cate").each(function(i,v) {
    var tree = $(v).attr('data-tree');
    var lft = $(v).attr('data-lft');
    var rgt = $(v).attr('data-rgt');
    if(tree*1 == treeParent && lft*1> lftParent && rgt*1 < rgtParent){
        $(v).toggle();
    }
}); 
$(this).toggleClass('glyphicon-triangle-right');
$(this).toggleClass('glyphicon-triangle-left');
});
Js;
$this->registerJs($js);
?>

