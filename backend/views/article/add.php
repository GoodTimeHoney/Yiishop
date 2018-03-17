<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/16
 * Time: 18:07
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($article,"title");
echo $form->field($article,"introduce")->textarea();
echo $form->field($article,"sort")->textInput(["value"=>100]);
echo $form->field($article,"status")->inline()->radioList(["下线","上线"],["value"=>1]);
echo $form->field($article,"cate_id")->dropDownList($catesArr);
//echo $form->field($artContent,"detail")->textarea();
echo $form->field($artContent,'detail')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
