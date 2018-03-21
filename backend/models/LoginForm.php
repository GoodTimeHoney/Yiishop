<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/21
 * Time: 14:26
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends  Model
{
   //1.设置属性
    public  $username;
    public  $password;

    //2.设置规则
    public  function  rules()
    {
        return [
            [['username','password'],'required'],

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