<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'code' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 4,
                'minLength' => 3,
            ],
        ];
    }



    public function actionIndex()
    {



        return $this->render('index');
    }

    /*用户注册*/
    public  function  actionReg(){
        $user=new User();
        $request=\Yii::$app->request;
        if($request->isPost){
//            exit('1111');
            $user->load($request->post());
            if($user->validate()){
               $user->auth_key=\Yii::$app->security->generateRandomString();
               $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);
               if($user->save(false)){
                   $result=[
                       'status'=>1,
                       'msg'=>'注册成功',
                       'data'=>""
                   ];
                   return Json::encode($result);
               }
            }else{
                $result=[
                    'status'=>0,
                    'msg'=>'注册失败',
                    'data'=>$user->errors
                ];
                return Json::encode($result);
              //  var_dump($user->errors);exit;
            }

        }
        return $this->render("reg");
    }



    //短信验证码
    public  function  actionSendSms($mobile){
         //1.生成验证码
        $code=rand(100000,999999);
         //2.发送验证码
        $config = [
            'access_key' => 'LTAIYJXfGAZIrXl5',
            'access_secret' => '6SyVfuB22ax0a78x5rBIcVXP39U117',
            'sign_name' => '超超',
        ];
        $aliSms=new  AliSms();
        $response = $aliSms->sendSms($mobile, 'SMS_128636100', ['code'=>$code], $config);
//        var_dump($response);exit;
        if($response->Message=='OK'){
            //3.把验证码保存到session中，mobile键名,code值
            $session=\Yii::$app->session;
            $session->set("tel_".$mobile,$code);
            return $code;
        }else{
            var_dump($response->Message);
        }


    }


//    public  function actionCheckSms($mobile,$code){
//
//        //通过手机号去除验证码
//        $codeOld=\Yii::$app->session->get("tel_".$mobile);
//       // exit($mobile);
//        //判断验证码
//        if($code==$codeOld){
//             echo "正确";
//        }else{
//            echo "错误";
//        }
//    }
/*用户登录*/
public  function  actionLogin(){
         $model=new LoginForm();
         $user=new  User();
         $request=\Yii::$app->request;
         if($request->isPost) {
             //绑定数据
            $model->load($request->post());
             if($model->validate()){
                 //判断用户是否存在
                 $user = User::find()->where(['username' => $model->username])->one();
                 if ($user) {
                     //用户密码
                     if (\Yii::$app->security->validatePassword($model->password, $user->password_hash)) {
                         //var_dump("密码没毛病");
                          \Yii::$app->user->login($user,$model->rememberMe?3600*24*7:0);
//                          exit("111");
                         //保存
                         $user->login_time = time();
//                         var_dump($user->login_ip);exit;
                         $user->login_ip = ip2long(\Yii::$app->request->userIP);
                         if ($user->save(false)) {
                             $result = [
                                 'status' => 1,
                                 'msg' => '登录成功',
                                 'data' => ""
                             ];
                             return Json::encode($result);
                         }
                     } else {
                         $result = [
                             'status' => 0,
                             'msg' => '密码错误',
                             'data' => ""
                         ];
                         return Json::encode($result);
                     }
                 } else {
                     $result = [
                         'status' => -1,
                         'msg' => '用户名错误',
                         'data' =>$model->errors,
                     ];
                     return Json::encode($result);
                 }



             }else{
                 $result = [
                     'status' => -2,
                     'msg' => '验证错误',
                     'data' => ""
                 ];
                 return Json::encode($result);
             }


         }

        return $this->render("login");
}


//注销
    public  function  actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(["login"]);
    }


    //列表页
    public  function  actionList(){
        return $this->render("list");
    }

}



