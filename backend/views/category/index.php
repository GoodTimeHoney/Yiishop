<h1>货物表</h1>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
<table class="table table-condensed table-hover">

        <tr>
            <td>
            <?= \leandrogehlen\treegrid\TreeGrid::widget([
                'dataProvider' => $dataProvider,
                'keyColumnName' => 'id',
                'parentColumnName' => 'parend_id',
                'parentRootValue' => '0', //first parentId value
                'pluginOptions' => [
                    'initialState' => 'collapsed',
                ],
                'columns' => [
                    'name',
                    'id',
                    'parend_id',
                    'introduce',
                   'depth',
                   ['class' => \backend\components\ActionColumn::className()]

                ]
            ]); ?>

            </td>


        </tr>

</table>
