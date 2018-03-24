<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table table-responsive">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>权限</td>
        <td>操作</td>
    </tr>
    <?php foreach ($role as $row):?>
        <tr>
            <td><?=$row->name?></td>
            <td><?=$row->description?></td>
            <td>
                <?php
                    //实列化
                    $auth = \yii::$app->authManager;
                    //角色权限获得角色名
                    $pers= $auth->getPermissionsByRole($row->name);
//                    var_dump($per);
                $html = "";
                //循环
                foreach ($pers as $per){
                    $html.=$per->description.",";
                }
//                去掉，
                $html = trim($html,",");
                echo $html;
                ?>
            </td>
            <td>
                <a href="<?=yii\helpers\Url::to(['edit','name'=>$row->name])?>" class="glyphicon glyphicon-pencil btn btn-warning"></a>
                <a href="<?=yii\helpers\Url::to(['del','name'=>$row->name])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>