<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/15
 * Time: 16:49
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name")->textInput(["disabled"=>""]);
echo $form->field($model,"description")->textarea();
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
