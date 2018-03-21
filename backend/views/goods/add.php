<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/15
 * Time: 16:49
 */
/** @var $this \yii\web\View */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($good,"name");
echo $form->field($good,"sn");
echo $form->field($good, 'logo')->widget(\manks\FileInput::className(),[]);

echo $form->field($good, 'images')->widget('manks\FileInput', [
    'clientOptions' => [
        'pick' => [
            'multiple' => true,
        ],
        // 'server' => Url::to('upload/u2'),
        // 'accept' => [
        // 	'extensions' => 'png',
        // ],
    ],
]);


echo $form->field($good,"goods_category_id")->dropDownList($catesArr);
echo $form->field($good,"brand_id")->dropDownList($brandsArr);
echo $form->field($good,"market_price");
echo $form->field($good,"shop_price");
echo $form->field($good,"stock");
echo $form->field($good,"is_on_sale")->inline()->radioList([0=>"下线",1=>"上线"],["value"=>1]);
echo $form->field($good,"sort");
echo $form->field($goodsIntro,'content')->widget('kucha\ueditor\UEditor',[]);

echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();
