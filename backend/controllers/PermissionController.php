<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    /*权限显示*/
    public function actionIndex()
    {
        $auth=\Yii::$app->authManager;
        //找到所有权限
        $pers=$auth->getPermissions();
        return $this->render('index',compact("pers"));
    }
     /*权限添加*/
    public  function  actionAdd(){
        $model=new AuthItem();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //创建auth对象
            $auth=\Yii::$app->authManager;
            //创建权限
            $per=$auth->createPermission($model->name);
            //设置描述
            $per->description=$model->description;
            //权限入库
            if($auth->add($per)){
            \Yii::$app->session->setFlash("success","添加".$model->name."权限成功");
            }
             return $this->refresh();
        }

        //现实视图
        return $this->render("add",compact("model"));
    }
    /*权限编辑*/
    public  function  actionEdit($name){
        $model=AuthItem::findOne($name);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //创建auth对象
            $auth=\Yii::$app->authManager;
            //得到权限
            $per=$auth->getPermission($model->name);
            //设置描述
            $per->description=$model->description;
            //权限入库
            if($auth->update($model->name,$per)){
                \Yii::$app->session->setFlash("success","添加".$model->name."权限成功");
            }
            return $this->redirect(["permission/index"]);
        }

        //现实视图
        return $this->render("edit",compact("model"));
    }
    /*权限删除*/
    public  function  actionDel($name){
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //得到权限
        $per=$auth->getPermission($name);
        //删除权限
        if($auth->remove($per)){
               \Yii::$app->session->setFlash("success",'删除'.$name."成功");
            //返回首页
            return $this->redirect(["index"]);
        }

    }
}
