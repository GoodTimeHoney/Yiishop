
<h1>文章管理表</h1>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">
    <tr>
        <th>id</th>
        <th>标题</th>
        <th>介绍</th>
        <th>排序</th>
        <th>状态</th>
        <th>分类id</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($arts as $art):
        ?>
        <tr>
            <td class="active"><?=$art->id?></td>
            <td class="active"><?=$art->title?></td>
            <td class="info"><?=$art->introduce?></td>
            <td class="success"><?=$art->sort?></td>
            <td class="info"><?php
                if( $art->status){
                     echo  \yii\bootstrap\Html::a("",["#","id"=>$art->id],["class"=>"glyphicon glyphicon-ok"]);
                }else{
                    echo  \yii\bootstrap\Html::a("",["#","id"=>$art->id],["class"=>"glyphicon glyphicon-remove"]);

                }
                ?></td>
            <td class="success"><?=$art->cate->name?></td>
            <td class="info"><?=date("Y-m-d H:i:s",$art->create_time)?></td>
            <td class="success"><?=date("Y-m-d H:i:s",$art->update_time)?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','id'=>$art->id])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$art->id])?>" class="btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
<?=\yii\widgets\LinkPager::widget([
    "pagination" => $page,
])?>