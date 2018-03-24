<h1>权限列表</h1>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">
    <tr>
        <th>名称</th>
        <th>列表</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($pers as $per):
        ?>
        <tr>
            <td class="active"><?=strpos($per->name,"/")!==false?"---":""?><?=$per->name?></td>
            <td class="info"><?=$per->description?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','name'=>$per->name])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','name'=>$per->name])?>" class="btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
