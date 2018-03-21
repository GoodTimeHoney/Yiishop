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

echo  \yii\bootstrap\Html::a("首页",["index"],["class"=>"btn btn-success"]);

\yii\bootstrap\ActiveForm::end();

//定义JS代码
$js=<<<JS

  var treeObj = $.fn.zTree.getZTreeObj("w1");
  treeObj.expandAll(true);

JS;
//注册
$this->registerJs($js);
?>

<script>
    function onClick(e,treeId, treeNode) {
       $("#category-parend_id").val(treeNode.id);
    }
</script>
