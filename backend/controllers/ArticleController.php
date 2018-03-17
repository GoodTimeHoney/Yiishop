<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategroy;
use backend\models\ArticleContent;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
   //现实列表
    public function actionIndex()
    {
        //定义一个销售的数组
        //$sta=["下线","上线"];
        //得到所有数据

        $query=Article::find()->orderBy(["sort"=>"desc"]);

        $count=$query->count();//得到总条数

        // 使用总数来创建一个分页对象
        $page = new Pagination([
            "pageSize"=>2,//每页现实条数
            "totalCount" => $count ,//总条数

        ]);
        //查数据
        $arts=$query->offset($page->offset)->limit($page->limit)->all();


        return $this->render('index',compact("arts",'page'));
    }


    //添加
    public  function  actionAdd(){
        //创建文章模型
         $article=new Article();
         //创建文章内容对象
        $artContent=new  ArticleContent();
       //创建文章分类模型
        $article_cate=ArticleCategroy::find()->all();
         //二维转一维
         $catesArr=ArrayHelper::map($article_cate,'id','name');
         //判断提交方式
         $request=\Yii::$app->request;
           if($request->isPost){
                 //文章表绑定数据
               $article->load($request->post());

               //文章后台验证
               if($article->validate()){
                   //文章保存数据
                   if($article->save()){
                         //文章内容绑定
                       $artContent->load($request->post());
                       //文章内容验证
                       if($artContent->validate()){
                           //给文章id赋值
                           $artContent->article_id=$article->id;
                           //保存数据
                           if($artContent->save()){
                                //提示
                               \Yii::$app->session->setFlash("success","添加成功");
                               return $this->redirect(["index"]);
                           }

                       }

                   }

               }else{
                   //打印错误
                   //TODO
                   var_dump($article->errors);exit;
               }

           }
         return $this->render("add",compact("article",'artContent',"catesArr"));
    }


    public  function  actionEdit($id){
        //创建文章模型
        $article=Article::findOne($id);
        //创建文章内容对象
        $artContent=ArticleContent::findOne($id);
        //创建文章分类模型
        $article_cate=ArticleCategroy::find()->all();
        //二维转一维
        $catesArr=ArrayHelper::map($article_cate,'id','name');
        //判断提交方式
        $request=\Yii::$app->request;
        if($request->isPost){
            //文章表绑定数据
            $article->load($request->post());

            //文章后台验证
            if($article->validate()){
                //文章保存数据
                if($article->save()){
                    //文章内容绑定
                    $artContent->load($request->post());
                    //文章内容验证
                    if($artContent->validate()){
                        //给文章id赋值
                        $artContent->article_id=$article->id;
                        //保存数据
                        if($artContent->save()){
                            //提示
                            \Yii::$app->session->setFlash("success","添加成功");
                            return $this->redirect(["index"]);
                        }

                    }

                }

            }else{
                //打印错误
                //TODO
                var_dump($article->errors);exit;
            }

        }
        return $this->render("add",compact("article",'artContent',"catesArr"));
    }

    public  function  actionDel($id){
         if(Article::findOne($id)->delete()){
                if(ArticleContent::findOne($id)->delete()){
                    //提示删除成功跳转首页
                    \Yii::$app->session->setFlash("success","删除成功");
                    return $this->redirect(["index"]);
                }
         }
    }

}
