<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Shopper;
use yii\helpers\Json;
use yii\web\Cookie;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    //商品详情
    public  function actionDetail($id){

        $good=Goods::findOne($id);
     return $this->render("detail",compact("good"));
    }

    public  function actionAddCart($id,$amount){
        if(\Yii::$app->user->isGuest){
            //未登录存cookie中   把id当键名，amount当键值
            //先得到cookie对象
            $getCookie=\Yii::$app->request->cookies;
            $cart=$getCookie->getValue("cart",[]);
            //判断当前的id购物车是否已存在，如果存在累加，不存在新增
//            var_dump(array_key_exists($id,$cart));exit;
            if(array_key_exists($id,$cart)){

                //存在累加
                $cart[$id]+=$amount;

            }else{
                //不存在新增
                $cart[$id]=(int)$amount;
            }
            //1.实例化一个cookie对象
            $setCookie=\Yii::$app->response->cookies;
            //2.创建一个cookie对象
            $cookie=new Cookie([
                 "name" => 'cart',
                 "value" =>$cart,
                'expire'=>time()+3600*24*7,
            ]);
            //3.添加cookie对象
            $setCookie->add($cookie);
            return $this->redirect(["cart-list"]);
        }else{
            $request=new Request();
            $shopper=new Shopper();
            //判断提交方式
            if($request->isGet){
                //判断是否存在
                $cart_goods=Shopper::find()->where(["user_id"=>\Yii::$app->user->id,"goods_id"=>$id])->one();
                if($cart_goods){
                    //存在累加
                    $cart_goods->amount+=$amount;
                    $cart_goods->save();
                    return $this->redirect(['cart-list']);
                }else{
                    //新增
                    $shopper->user_id=\Yii::$app->user->id;
                    $shopper->goods_id=$id;
                    $shopper->amount=(int)$amount;
                    $shopper->save();
                    return $this->redirect(['cart-list']);
                }

            }


        }

       // var_dump($id,$amount);
    }

    //购物车列表
    public  function actionCartList(){
      //判断用户是否登录
        if(\Yii::$app->user->isGuest){
             //没登录从cookie中去
            $cart=\Yii::$app->request->cookies->getValue("cart",[]);
            $goodIds=array_keys($cart);
            //取购物车的所有商品
            $goods=Goods::find()->where(["in","id",$goodIds])->all();
            //var_dump($goods);exit;
        }else{

             //登录
            $shopper=Shopper::find()->where(["user_id"=>\Yii::$app->user->id])->asArray()->all();
               $amount=array_column($shopper,"amount");
               $goodIds=array_column($shopper,"goods_id");
               $cart=array_combine($goodIds,$amount);
               $goods=Goods::find()->where(["in","id",$goodIds])->all();



        }
      return $this->render("flow1",compact("goods","cart"));
    }


    //修改cart
    public  function  actionUpdataCart($id,$amount){
       //判断登录状态
        if(\Yii::$app->user->isGuest){
             //没登录状态
            $cart=\Yii::$app->request->cookies->getValue("cart",[]);
            $cart[$id]=$amount;
            //1.实例化一个cookie对象
            $setCookie=\Yii::$app->response->cookies;
            //2.创建一个cookie对象
            $cookie=new Cookie([
                "name" => 'cart',
                "value" =>$cart,
            ]);
            //3.添加cookie对象
            $setCookie->add($cookie);
        }else{
            //登录状态
            Shopper::updateAll(['amount'=>$amount],['goods_id'=>$id]);

        }
    }

   //删除cart
    public  function  actionDelCart($id){
        //判断登录状态
        if(\Yii::$app->user->isGuest){
            //没登录状态
            $cart=\Yii::$app->request->cookies->getValue("cart",[]);
            //删除对象的数据
            unset($cart[$id]);
            //1.实例化一个cookie对象
            $setCookie=\Yii::$app->response->cookies;
            //2.创建一个cookie对象
            $cookie=new Cookie([
                "name" => 'cart',
                "value" =>$cart,
            ]);
            //3.添加cookie对象
            $setCookie->add($cookie);

            return Json::encode([
                'status'=>1,
                'msg'=>"删除成功",
            ]);
        }else{
            //登录状态
            if(Shopper::deleteAll(['goods_id'=>$id])){
                return Json::encode([
                    'status'=>1,
                    'msg'=>"删除成功",
                ]);
            }
        }

    }

    public  function actionTest(){
        $getCookie=\Yii::$app->request->cookies;
        var_dump($getCookie->getValue("cart"));
    }
}
