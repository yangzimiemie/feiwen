<a href="index" class="btn btn-success glyphicon glyphicon-arrow-right col-lg-offset-10"></a>
<?php
/** @var $this \yii\web\View */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($cate,'name');
echo $form->field($cate,'detail')->textarea();
echo $form->field($cate,'parent_id')->hiddenInput(['value'=>0]);
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
			},
			callback:{
			  onClick:onClick
			}
		}',
    'nodes' => $cateJson
]);
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn-info']);
\yii\bootstrap\ActiveForm::end();
$js=<<<Js

            var treeObj = $.fn.zTree.getZTreeObj("w1");
            var node = treeObj.getNodeByParam("id", "$cate->parent_id", null);
           treeObj.selectNode(node);
           
            treeObj.expandAll(true);
Js;
$this->registerJs($js);
?>
<script>
    function onClick(e,treeId, treeNode) {
//        console.dir(e);
        $("#goodscate-parent_id").val(treeNode.id);
        console.dir(treeNode.id);
//        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//        zTree.expandNode(treeNode);
    }
</script>

