<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">
    <tr>
        <th>id</th>
        <th>书名</th>
        <th>状态</th>
        <th>排序</th>
        <th>介绍</th>
        <th>帮助状态</th>
        <th>编辑</th>
    </tr>
    <?php
    foreach ($article_cates as $article_cate):
        ?>
        <tr>
            <td class="active"><?=$article_cate->id?></td>
            <td class="active"><?=$article_cate->name?></td>
            <td class="info"><?=$sta[$article_cate->status]?></td>
            <td class="success"><?=$article_cate->sort?></td>
            <td class="info"><?=$article_cate->introduce?></td>
            <td class="success"><?=$article_cate->is_help?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','id'=>$article_cate->id])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$article_cate->id])?>" class="btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>