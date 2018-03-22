<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\bootstrap\Html;

class AdminController extends \yii\web\Controller
{
    //会员显示
    public function actionIndex()
    {
        $admins=Admin::find()->all();
        return $this->render('index',compact("admins"));
    }
    //会员登录
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
                 //var_dump($admin->password);exit;
                 if(\Yii::$app->security->validatePassword($model->password,$admin->password)){
                     \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);

                     //保存
                     $admin->last_login_time=time();
                     $admin->last_login_ip=ip2long(\Yii::$app->request->userIP);
//                     var_dump($admin->last_login_ip);exit;

                     if($admin->save()){
                         \Yii::$app->session->setFlash("danger","登录成功");
                         //跳转到首页
                         return $this->redirect(["admin/index"]);
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


     //会员添加
    public  function  actionAdd(){
         $admin=new  Admin();
        $admin->setScenario('create');
         $request=\Yii::$app->request;
         if($request->isPost){
             $admin->load($request->post());
             if($admin->validate()){

                 //给密码加密
                 $admin->password=\Yii::$app->security->generatePasswordHash($admin->password);
                 //随机生成令牌
                 $admin->token=\Yii::$app->security->generateRandomString();
                 $admin->token_create_time=time();
                 $admin->add_time=time();
                     if($admin->save()){
                         \Yii::$app->session->setFlash("success","添加成功");
                         return $this->redirect(["index"]);
                     }
             }else{
                 var_dump($admin->errors);exit;
             }
         }
         return $this->render("add",compact("admin"));
    }

    //会员编辑
    public  function  actionEdit($id){
        $admin=Admin::findOne($id);
        $admin->setScenario('update');
        $password=$admin->password;
        $request=\Yii::$app->request;
        if($request->isPost){
            $admin->load($request->post());
            if($admin->validate()){

                //给密码加密

                $admin->password=$admin->password?\Yii::$app->security->generatePasswordHash($admin->password):$password;

                //随机生成令牌
                $admin->token=\Yii::$app->security->generateRandomString();
                $admin->token_create_time=time();
                $admin->add_time=time();
                if($admin->save()){
                    \Yii::$app->session->setFlash("success","编辑成功");
                    return $this->redirect(["index"]);
                }
            }else{
                var_dump($admin->errors);exit;
            }
        }
        return $this->render("add",compact("admin"));
    }

   //删除
    public  function  actionDel($id){
        if(Admin::findOne($id)->delete()){
            \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }

   //会员退出
     public  function  actionLogout(){
         \Yii::$app->user->logout();
         return $this->redirect(["login"]);
     }


}
