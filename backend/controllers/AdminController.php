<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\bootstrap\Html;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
     public  function  actionLogin(){
            //生成一个表单模式
         $model=new  LoginForm();
         $admin=new Admin();
         $request=\Yii::$app->request;
         if($request->isPost){
             //绑定数据
             $model->load($request->post());
//             var_dump($model->password);exit;
           $admin=Admin::find()->where(['username'=>$model->username])->one();
           //判断用户是否存在
             if($admin){
                 //用户存在
                 if($admin->password==$model->password){
                     \Yii::$app->user->login($admin);

                     //保存
                     $admin->last_login_time=time();
                     $admin->last_login_ip=\Yii::$app->request->userIP;
//                     var_dump($admin->last_login_ip);exit;

                     if($admin->save()){
                         \Yii::$app->session->setFlash("danger","登录成功");
                         //跳转到首页
                         return $this->redirect(["brand/index"]);
                     }else{
                         var_dump($admin->errors);exit;
                     }
                 }else{
                     $model->addError("password","密码错误");
                 }

             }else{
              //用户名不存在
                 $model->addError("username","用户名不存在");

             }


         }

         return $this->render("login",compact("model"));
     }

     public  function  actionLogout(){
         \Yii::$app->user->logout();
         return $this->redirect(["login"]);
     }


}
