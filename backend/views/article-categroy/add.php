<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/16
 * Time: 18:07
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($artCate,"name");
echo $form->field($artCate,"sort");
echo $form->field($artCate,"status")->inline()->radioList(["上线","下线"],["value"=>0]);
echo $form->field($artCate,"introduce")->textarea();
echo $form->field($artCate,"is_help")->inline()->radioList(["不帮助","帮助"],["value"=>0]);
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
