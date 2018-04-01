<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\PayGoods;
use frontend\models\SendGoods;
use frontend\models\Shopper;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest){
            return $this->redirect(["user/login",'url'=>'/order/index']);
        }
        $shopper=Shopper::find()->where(["user_id"=>\Yii::$app->user->id])->asArray()->all();
        $amount=array_column($shopper,"amount");
        $goodIds=array_column($shopper,"goods_id");
        $cart=array_combine($goodIds,$amount);
        $goods=Goods::find()->where(["in","id",$goodIds])->all();

        //配送方式
        $goodsSend=SendGoods::find()->all();

        //收货地址
         $addresses=Address::find()->where(["user_id"=>\Yii::$app->user->id])->all();

         //支付方式
         $payGoods=PayGoods::find()->all();
            return $this->render('flow2',compact("goods","goodsSend","addresses","payGoods","cart"));


    }

}
