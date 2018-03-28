<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;

class AddressController extends \yii\web\Controller
{
    public function actionIndex()
    {

//
    }
   //添加地址
    public  function  actionAddress(){
        $addresses=Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        if (\Yii::$app->request->isPost){
             $address=new  Address();
             $address->load(\Yii::$app->request->post());
             if($address->validate()){
                 //给userid赋值
                 $address->user_id=\Yii::$app->user->id;
                 if($address->status===null){
                     $address->status=0;
                 }else{
                     $address->status=1;
                     Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);
                 }
                 //保存数据
                 if ($address->save()){
                     $result=[
                         'status'=>1,
                         'msg'=>"操作成功",
                     ];
                 }
                 return Json::encode($result);

             }else{
                 var_dump($address->errors);exit;
             }

        }
        return $this->render("address",compact("addresses"));
    }

    //删除地址
     public  function  actionDel($id){
       if(Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete()){
           return Json::encode([
               'status'=>1,
               'msg'=>"删除成功",
           ]);
       }
     }



}
