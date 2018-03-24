<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    /*角色显示*/
    public function actionIndex()
    {
        $auth=\Yii::$app->authManager;
        //找到所有权限
        $roles=$auth->getRoles();
        return $this->render('index',compact("roles"));
    }
     /*角色添加*/
    public  function  actionAdd(){
        $model=new AuthItem();
        //创建auth对象
        $auth=\Yii::$app->authManager;
         //得到所有的权限
        $pers=$auth->getPermissions();
        $persArry=ArrayHelper::map($pers,"name","description");
//        var_dump($persArry);exit;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
//            var_dump($model->permissions);exit;
            //创建角色
            $role=$auth->createRole($model->name);
            //设置描述
            $role->description=$model->description;
            //权限入库
            if($auth->add($role)){
                //判断有没有添加权限
                if($model->permissions){
                    //给当前角色添加权限
                    foreach ($model->permissions as $perName){
                        //通过权限名称得到权限对象
                        $per=$auth->getPermission($perName);
                        //给角色添加权限
                        $auth->addChild($role,$per);
                    }
                }
            \Yii::$app->session->setFlash("success","添加".$model->name."权限成功");
            }
             return $this->refresh();
        }

        //现实视图
        return $this->render("add",compact("model","persArry"));
    }
    /*角色编辑*/
    public  function  actionEdit($name){
        $model=AuthItem::findOne($name);
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //得到所有的权限
        $pers=$auth->getPermissions();
        $persArry=ArrayHelper::map($pers,"name","description");
        //得到当前角色所对应的所有权限
        $rolePers=$auth->getPermissionsByRole($name);
         $model->permissions=array_keys($rolePers);
//        var_dump($persArry);exit;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
//            var_dump($model->permissions);exit;
            //得到角色
            $role=$auth->getRole($model->name);
            //设置描述
            $role->description=$model->description;
            //更新角色
            if($auth->update($model->name,$role)){
                //删除当前角色有没有添加权限
                $auth->removeChildren($role);
                //判断有没有添加权限
                if($model->permissions){
                    //给当前角色添加权限
                    foreach ($model->permissions as $perName){
                        //通过权限名称得到权限对象
                        $per=$auth->getPermission($perName);
                        //给角色添加权限
                        $auth->addChild($role,$per);
                    }
                }
                \Yii::$app->session->setFlash("success","添加".$model->name."权限成功");
            }
            return $this->redirect(["index"]);
        }

        //现实视图
        return $this->render("edit",compact("model","persArry"));
    }
    /*角色删除*/
    public  function  actionDel($name){
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //得到权限
        $role=$auth->getRole($name);
        //删除权限
        if($auth->remove($role)){
               \Yii::$app->session->setFlash("success",'删除'.$name."成功");
            //返回首页
            return $this->redirect(["index"]);
        }

    }
}
