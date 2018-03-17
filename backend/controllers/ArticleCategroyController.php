<?php

namespace backend\controllers;

use backend\models\ArticleCategroy;

class ArticleCategroyController extends \yii\web\Controller
{
    //显示列表
    public function actionIndex()
    {
        $sta=["上线","下线"];
        $article_cates=ArticleCategroy::find()->all();
        return $this->render('index',compact("article_cates","sta"));
    }
   //添加
    public  function  actionAdd(){
        $artCate=new ArticleCategroy();
        //判断数据提交方式
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            //绑定数据
            $artCate->load($request->post());
            //验证数据
            if($artCate->validate()){
                 if($artCate->save()){
                     \Yii::$app->session->setFlash("success","添加分类成功");
                     return $this->redirect(['index']);
                 }
            }else{
               // var_dump($artCate->errors);exit;
            }
        }
        //返回数据
        return $this->render('add',compact("artCate"));
    }


    //编辑
    public  function  actionEdit($id){
        $artCate=ArticleCategroy::findOne($id);
        //判断数据提交方式
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            //绑定数据
            $artCate->load($request->post());
            //验证数据
            if($artCate->validate()){
                if($artCate->save()){
                    \Yii::$app->session->setFlash("success","编辑分类成功");
                    return $this->redirect(['index']);
                }
            }else{
                // var_dump($artCate->errors);exit;
            }
        }
        //返回数据
        return $this->render('add',compact("artCate"));
    }

    //删除
    public  function  actionDel($id){
        if(ArticleCategroy::findOne($id)){
            return $this->redirect(["index"]);
        }
    }

}
