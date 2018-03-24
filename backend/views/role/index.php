<h1>角色列表</h1>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">
    <tr>
        <th>名称</th>
        <th>列表</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($roles as $role):
        ?>
        <tr>
            <td class="active"><?=strpos($role->name,"/")!==false?"---":""?><?=$role->name?></td>
            <td class="info"><?=$role->description?></td>
            <td class="success"><?php
                //得到当前角色的所有权限
                $auth=Yii::$app->authManager;
                //通过角色得到所有权限
                $pers=$auth->getPermissionsByRole($role->name);
                $html="";
                foreach ($pers as $per){
                    $html.=$per->description.",";
                }
                //去除逗号
                $html=trim($html,",");
               echo  $html;
                ?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','name'=>$role->name])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','name'=>$role->name])?>" class="btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
