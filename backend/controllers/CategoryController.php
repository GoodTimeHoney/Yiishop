<?php

namespace backend\controllers;

use backend\models\Category;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\Json;

class CategoryController extends \yii\web\Controller
{

    //显示数据
    public function actionIndex()
    {
        $query = Category::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public  function  actionAdd(){
        $cate=new Category();
        //查出所有的数据
         $cates=Category::find()->asArray()->all();
        $cates[]=['id'=>0,'name'=>'一级分类','parend_id'=>0];
         $catesJson=json_encode($cates);

        //判断提交方式
        $request=\Yii::$app->request;
        if($request->isPost){
             //绑定数据
            $cate->load($request->post());
            if($cate->validate()){
                     //如果parend_id=0,添加一级分类
                   if($cate->parend_id==0){
                       //一级分类
                       $cate->makeRoot();
                       //提示信息
                       \Yii::$app->session->setFlash("success","创建一级分类".$cate->name."成功");
                        //刷新
                       return $this->refresh();
                   }else{
                       //二级分类
                       //找到父分类对象
                       $cateParent=Category::findOne($cate->parend_id);
                       $cate->prependTo($cateParent);
                       //提示信息
                       \Yii::$app->session->setFlash("success","创建{$cateParent->name}的子分类 ".$cate->name." 成功");
                       //刷新
                       return $this->refresh();
                   }

            }else{

              var_dump($cate->errors);exit;
            }


        }

        //分配视图
        return $this->render("add",compact("cate","catesJson"));
    }


    //编辑
    public  function  actionUpdate($id){
        $cate=Category::findOne($id);
        //查出所有的数据
        $cates=Category::find()->asArray()->all();
        $cates[]=['id'=>0,'name'=>'一级分类','parend_id'=>0];
        $catesJson=json_encode($cates);
        //判断提交方式
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $cate->load($request->post());
            if($cate->validate()){


               try{

                   //如果parend_id=0,添加一级分类
                   if($cate->parend_id==0){
                       //一级分类
                       $cate->makeRoot();
                       //提示信息
                       \Yii::$app->session->setFlash("success","创建一级分类".$cate->name."成功");
                       //刷新
                       return $this->refresh();
                   }else{
                       //二级分类
                       //找到父分类对象
                       $cateParent=Category::findOne($cate->parend_id);
                       $cate->prependTo($cateParent);
                       //提示信息
                       \Yii::$app->session->setFlash("success","创建{$cateParent->name}的子分类 ".$cate->name." 成功");
                       //刷新
                       return $this->refresh();
                    }

                 } catch(Exception $exception){
                   \Yii::$app->session->setFlash("danger",$exception->getMessage());
                }

            }else{

                var_dump($cate->errors);exit;
            }
        }

        //分配视图
        return $this->render("add",compact("cate","catesJson"));
    }


    //删除
    public  function  actionDelete($id){
        try{
            if(Category::findOne($id)->deleteWithChildren()){
                return $this->redirect(['index']);
            }
        }catch(Exception $exception){
            \Yii::$app->session->setFlash("danger",$exception->getMessage());
        }
    }
}
