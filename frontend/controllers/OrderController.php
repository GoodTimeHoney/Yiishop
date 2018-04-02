<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\Order;
use backend\models\OrderDetail;
use frontend\models\Address;
use frontend\models\PayGoods;
use frontend\models\SendGoods;
use frontend\models\Shopper;
use yii\db\Exception;
use yii\helpers\Json;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest){
            return $this->redirect(["user/login",'url'=>'/order/index']);
        }
        $userId=\Yii::$app->user->id;

        $shopper=Shopper::find()->where(["user_id"=>$userId])->asArray()->all();
        $amount=array_column($shopper,"amount");
        $goodIds=array_column($shopper,"goods_id");
        $cart=array_combine($goodIds,$amount);
        $goods=Goods::find()->where(["in","id",$goodIds])->all();

        //总价格
        $totalPrice=0;
        foreach ($goods as $good){
            $totalPrice+=$good->shop_price*$cart[$good->id];
        }

        //总数量
        $totalNum=0;
        foreach ($goods as $good){
            $totalNum+=$cart[$good->id];
        }

        //配送方式
        $goodsSend=SendGoods::find()->all();

        //收货地址
         $addresses=Address::find()->where(["user_id"=>\Yii::$app->user->id])->all();

         //支付方式
         $payGoods=PayGoods::find()->all();


        $request=\Yii::$app->request;
        if ($request->isPost){



            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();//开启事物

            try {


                //创建订单对象
                $order=new Order();
                //取出地址
                $addressId=$request->post("address_id");
                $address=Address::findOne(["id"=>$addressId,'user_id'=>$userId]);
                //取出配送方式
                $deliveryId=$request->post("delivery");
                $delivery=SendGoods::findOne($deliveryId);
                //支付方式
                $payId=$request->post("pay");
                $payGood=PayGoods::findOne($payId);



                $order->user_id=$userId;
                $order->name=$address->user_name;
                $order->province=$address->province;
                $order->city=$address->city;
                $order->area=$address->area;
                $order->detail_address=$address->address;
                $order->tel=$address->mobile;

                $order->delivery_id=$delivery->id;
                $order->delivery_name=$delivery->send_way;
                $order->delivery_price=$delivery->send_money;

                $order->pay_type_id=$payGood->id;
                $order->pay_type_name=$payGood->pay_way;

                $order->price=$totalPrice+($delivery->send_money);
                $order->status=1;
                $order->trade_no=date("YmdHis").rand(100,999);
                $order->create_time=time();
                //保存数据
                if($order->save()){
                    //循环商品入库
                    foreach ($goods as $good){
                        //判断当前商品库存够不够
                        //1.找出当前商品
                        $curGood=Goods::findOne($good->id);
                        //2.判断库存
                        if($cart[$good->id]>$curGood->stock){
//                            exit("库存不足");
                            throw new  Exception("库存不足");
                        }
                        $orderDetail=new  OrderDetail();
                        $orderDetail->order_info_id=$order->id;
                        $orderDetail->goods_id=$good->goods_category_id;
                        $orderDetail->goods_name=$good->name;
                        $orderDetail->logo=$good->logo;
                        $orderDetail->price=$good->shop_price;
                        $orderDetail->amount=$cart[$good->id];
                        $orderDetail->total_price=$good->shop_price*$orderDetail->amount;
                        //保存数据
                        if($orderDetail->save()){
                            //把商品库存减掉
                            $curGood->stock=$curGood->stock-$cart[$good->id];
                            $curGood->save(false);
                        };
                    }



                }

                //清空购物车
                Shopper::deleteAll(["user_id"=>$userId]);

                $transaction->commit();//提交事物

                //返回数据
                return Json::encode([
                    'status'=>1,
                    'msg'=>'订单提交成功',
                ]);

            } catch(Exception $e) {

                $transaction->rollBack();//回滚

                //返回数据
                return Json::encode([
                    'status'=>0,
                    'msg'=>$e->getMessage(),
                ]);
            }



        }



        return $this->render('flow2',compact("goods","goodsSend","addresses","payGoods","cart","totalPrice","totalNum"));


    }



    //货物列表三
    public  function actionFlowThere(){

        return $this->render("flow3");
    }

}
