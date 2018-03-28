
<h1>会员管理表</h1>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">
    <tr>
        <th>id</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>口令创建时间</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($admins as $admin):
        ?>
        <tr>
            <td class="active"><?=$admin->id?></td>
            <td class="active"><?=$admin->username?></td>
            <td class="info"><?=$admin->email?></td>
            <td class="info"><?=date("Y-m-d h:i:s",$admin->token_create_time)?></td>
            <td class="success"><?=date("Y-m-d h:i:s",$admin->add_time)?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','id'=>$admin->id])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$admin->id])?>" class="btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>