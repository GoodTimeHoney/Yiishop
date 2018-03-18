<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/18
 * Time: 14:32
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();

echo  $form->field($cate,"name");
echo  $form->field($cate,"parend_id")->textInput(["value"=>0])->hiddenInput();

echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parend_id",
				}
			},
			callback: {
				onClick: onClick
			}
		}',
    'nodes' => $catesJson
]);


echo  $form->field($cate,"introduce")->textarea();
echo  \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
?>
<script>
    function onClick(e,treeId, treeNode) {
       $("#category-parend_id").val(treeNode.id);
    }
</script>
