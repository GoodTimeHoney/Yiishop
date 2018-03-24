<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/16
 * Time: 18:07
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,"username");
echo $form->field($admin,"password")->textInput(["value"=>""]);
echo $form->field($admin,"email");
echo $form->field($admin,"adminRole")->inline()->checkboxList($adminRole);
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
