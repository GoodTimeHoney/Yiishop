<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/27
 * Time: 14:37
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends  Model
{
//1.设置属性
    public  $username;
    public  $password;
    public  $checkCaptcha;//验证码
    public  $rememberMe=true;

    //2.设置规则
    public  function  rules()
    {
        return [
            [['username','password'],'required'],
            [["checkCaptcha"],'captcha','captchaAction' => 'user/code'],//验证码，
            ['rememberMe','safe'],
        ];
    }
    //设置标签
    public  function  attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
        ];
    }
}