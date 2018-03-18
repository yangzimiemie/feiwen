<?php
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($cate,'name');
echo $form->field($cate,'detail')->textarea();
echo $form->field($cate,'parent_id')->textInput(['value'=>0]);
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
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>
<?php
$js=<<<EOF

            var treeObj = $.fn.zTree.getZTreeObj("w1");
            treeObj.expandAll(true);

EOF;
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
