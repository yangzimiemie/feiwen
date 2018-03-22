<?php
/* @var $this yii\web\View */
?>
<h1>管理员列表</h1>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info glyphicon glyphicon-plus"></a>

    <table class="table table-responsive"
    <tr>
        <td>Id</td>
        <td>管理名</td>
        <td>email</td>
        <td>登录IP</td>
        <td>管理员头像</td>
        <td>管理状态</td>
        <td>操作</td>
    </tr>
<?php foreach ($admin  as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->username?></td>
        <td><?=$row->email?></td>
        <td><?=long2ip($row->login_ip)?></td>
        <td>
            <?php
            $imgFile =strpos($row->logo,'ttp://')?$row->logo:"/".$row->logo;
            echo \yii\bootstrap\Html::img($imgFile,['height'=>30]);
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