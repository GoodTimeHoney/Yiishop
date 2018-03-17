<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>图片</th>
        <th>状态</th>
        <th>排序</th>
        <th>介绍</th>
        <th>编辑</th>
    </tr>
    <?php
    foreach ($brands as $brand):
        ?>
        <tr>
            <td class="active"><?=$brand->id?></td>
            <td class="active"><?=$brand->name?></td>
            <td class="info"><img src="/<?=$brand->logo?>" width="30" style="border-radius: 50%"></td>
            <td class="info"><?=$sta[$brand->status]?></td>
            <td class="success"><?=$brand->sort?></td>
            <td class="info"><?=$brand->intro?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','id'=>$brand->id])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$brand->id])?>" class="btn btn-danger btn-sm">隐藏</a>
                <a href="<?=yii\helpers\Url::to(['show'])?>" class="btn btn-danger btn-sm">显示</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
<?=\yii\widgets\LinkPager::widget([
    "pagination" => $page,
])?>