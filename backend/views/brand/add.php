<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/15
 * Time: 16:49
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,"name");
echo $form->field($brand,"sort");
echo $form->field($brand,"status")->inline()->radioList(["下线","上线"],["value"=>1]);
echo $form->field($brand,"intro")->textarea();
echo $form->field($brand,"imgFile")->fileInput();
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
