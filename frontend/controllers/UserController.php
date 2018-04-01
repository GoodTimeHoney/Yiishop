<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;
use frontend\models\LoginForm;
use frontend\models\Shopper;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;
use yii\web\Cookie;
use yii\web\Request;

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

                         //同步本地cookie中的购物车到数据库中去
                           //1.取出cookie中的数据包
                         $getCookie=\Yii::$app->request->cookies;
                         $cart=$getCookie->getValue("cart",[]);
                           //2..把数据同步到数据库中去
                           $userId=\Yii::$app->user->id;
                           foreach ($cart as $goodId=>$num){
                               $cart_goods=Shopper::find()->where(["user_id"=>$userId,"goods_id"=>$goodId])->one();
                               if($cart_goods){
                                   //存在累加
                                   $cart_goods->amount+=(int)$num;
                                   $cart_goods->save();
                                   unset($cart[$goodId]);
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
                                   $cart_goods=new Shopper();
                                   //新增
                                   $cart_goods->user_id=$userId;
                                   $cart_goods->goods_id=$goodId;
                                   $cart_goods->amount=(int)$num;
                                   $cart_goods->save();
                                   unset($cart[$goodId]);
                                   //1.实例化一个cookie对象
                                   $setCookie=\Yii::$app->response->cookies;
                                   //2.创建一个cookie对象
                                   $cookie=new Cookie([
                                       "name" => 'cart',
                                       "value" =>$cart,
                                   ]);
                                   //3.添加cookie对象
                                   $setCookie->add($cookie);

                               }
                           }

                          //3.清空本地cookie中的数据


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
    public  function  actionList($id){
        //通过分类id找到当前的对象
        $cate=Category::findOne($id);
//
        //通过分类id找到所有的子孙分类
        $sonCates=Category::find()->where(["tree"=>$cate->tree])->andWhere(['>=','lft',$cate->lft])->andWhere(['<=','rgt',$cate->rgt])->asArray()->all();
        //二维转一维
        $cateId=array_column($sonCates,"id");
        //得到分类的所有商品
        $goods=Goods::find()->where(["in","goods_category_id",$cateId])->andWhere(['is_on_sale'=>1])->orderBy("sort")->all();
        //var_dump($goods);exit;
        return $this->render("list",compact("goods"));
    }

}



