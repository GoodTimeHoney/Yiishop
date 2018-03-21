<h1>商城表单</h1>



<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-danger pull-left">添加</a>
<a href="<?=yii\helpers\Url::to(['index'])?>" class="btn btn-danger pull-left">首页</a>

<form class="form-inline pull-right" >
    <select class="form-control" name="is_on_sale">
        <option>请选择</option>
        <option value="0" <?=Yii::$app->request->get('is_on_sale')==='0'?'selected':""?>>下线</option>
        <option value="1" <?=Yii::$app->request->get('is_on_sale')==='1'?'selected':""?>>上线</option>
    </select>
    <div class="form-group">
        <input type="text" class="form-control" id="minPrice" name="minPrice" placeholder="最低价" size="3" value="<?=Yii::$app->request->get('minPrice')?>">
    </div>--
    <div class="form-group">
        <input type="text" class="form-control" id="maxPrice" name="maxPrice" placeholder="最高价" size="3" value="<?=Yii::$app->request->get('maxPrice')?>">
    </div>--
    <div class="form-group">
        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字" size="6"  value="<?=Yii::$app->request->get('keyword')?>">
    </div>
    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
</form>



<table class="table table-condensed table-hover">
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>编号</th>
        <th>商品LOGO</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>库存</th>
        <th>是否上架</th>
        <th>排序</th>
        <th>创建时间</th>
        <th>编辑时间</th>
        <th>编辑</th>
    </tr>
    <?php
    foreach ($goods as $good):
        ?>
        <tr>
            <td class="active"><?=$good->id?></td>
            <td class="active"><?=$good->name?></td>
            <td class="info"><?=$good->sn?></td>
            <td class="success">
                <?php
                $imgPath=strpos($good->logo,'ttp://')?$good->logo:"/".$good->logo;
                echo \yii\bootstrap\Html::img($imgPath,['height'=>40]);
                ?>
            </td>
            <td class="info"><?=$good->cate->name?></td>
            <td class="success"><?=$good->brand->name?></td>
            <td class="info"><?=$good->market_price?></td>
            <td class="success"><?=$good->shop_price?></td>
            <td class="info"><?=$good->stock?></td>
            <td class="success"><?=$good->is_on_sale?></td>
            <td class="info"><?=$good->sort?></td>
            <td class="success"><?=date("Y-m-d H:i:s",$good->create_time)?></td>
            <td class="info"><?=date("Y-m-d H:i:s",$good->update_time)?></td>
            <td class="active">
                <a href="<?=yii\helpers\Url::to(['edit','id'=>$good->id])?>" class="btn btn-warning btn-sm">编辑</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$good->id])?>" class="btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
<?=\yii\widgets\LinkPager::widget([
    "pagination" => $page,
])?>
