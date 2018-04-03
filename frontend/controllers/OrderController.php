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
use EasyWeChat\Foundation\Application;
use Endroid\QrCode\QrCode;
use yii\helpers\Url;

class OrderController extends \yii\web\Controller
{

   public  $enableCsrfValidation=false;

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
                    'id'=>$order->id,
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
    public  function actionFlowThere($id){
        $order=Order::findOne($id);
//        var_dump($order);exit;

        //echo  $id;exit;
        return $this->render("flow3",compact("order"));
    }


    //微信支付
    public  function  actionWxin($id){
        $order=Order::findOne($id);
        switch ($order->pay_type_id){
            //支付宝
            case 1:
                break;
            //微信
            case 2:

                //创建
                $options=\Yii::$app->params['wx'];
                //var_dump($options);exit;
                //创建微信操作对象
                $app = new Application($options);
                //通过app找到支付对象
                $payment = $app->payment;

                $attributes = [
                    'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
                    'body'             => '刘氏集团',
                    'detail'           => '商品详情',
                    'out_trade_no'     => $order->trade_no,
                    'total_fee'        => $order->price*100, // 单位：分
                    'notify_url'       => Url::to(["order/notify"],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                    //  'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
                    // ...
                ];
                //生成订单
                $order = new \EasyWeChat\Payment\Order($attributes);

                //统一下单
                $result = $payment->prepare($order);

                if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                    // $prepayId = $result->prepay_id;
                    $qrCode = new QrCode($result->code_url);

                    header('Content-Type: '.$qrCode->getContentType());
                    echo $qrCode->writeString();

                }
                break;
        }
    }

   //微信返回地址
    public  function actionNotify(){

        //创建
        $options=\Yii::$app->params['wx'];
        //var_dump($options);exit;
        //创建微信操作对象
        $app = new Application($options);

        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
           // $order = 查询订单($notify->out_trade_no);
            $order=Order::findOne(["trade_no"=>$notify->out_trade_no]);
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
               // $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status =2;
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;


    }

}
