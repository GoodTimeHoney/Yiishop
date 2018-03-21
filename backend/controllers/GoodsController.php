<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{
    //现实列表
    public function actionIndex()
    {
        $query=Goods::find();
        $minPrice=\Yii::$app->request->get("minPrice");
        $maxPrice=\Yii::$app->request->get("maxPrice");
        $keyword=\Yii::$app->request->get("keyword");
        $is_on_sale=\Yii::$app->request->get('is_on_sale');
        //搜索编辑
        //最大值
        if($minPrice){
            $query->andWhere("shop_price>={$minPrice}");
        }
        //最小值
        if($maxPrice){
            $query->andWhere("shop_price<={$maxPrice}");
        }
        //商品名称和货号
       if($keyword!==""){

            $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
       }

       if($is_on_sale==="0"||$is_on_sale==="1"){
           $query->andWhere(['is_on_sale'=>$is_on_sale]);
       }



        $count=$query->count();//得到总条数

        // 使用总数来创建一个分页对象
        $page = new Pagination([
            "pageSize"=>2,//每页现实条数
            "totalCount" => $count ,//总条数

        ]);
        //查数据
        $goods=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',compact('goods','page'));
    }
  //添加列表
    public  function  actionAdd(){
         $good=new  Goods();
         //声明一个goods_intro
        $goodsIntro=new GoodsIntro();
         //查找categoryDepth=2
           $cates=Category::find()->orderBy('tree,lft')->all();
           $catesArr=ArrayHelper::map($cates,'id','nameText');

          //查找brand
          $brands=Brand::find()->all();
          $brandsArr=ArrayHelper::map($brands,'id','name');

         $request=\Yii::$app->request;
         if ($request->isPost){
             //给货物绑定数据
             $good->load($request->post());
             if($good->validate()){

                    //判断sn是否有值
                   if(!$good->sn){
                       //当天时间戳
                       $dayTime=strtotime(date("Ymd"));
                       //找出当日的商品数量
                       $count=Goods::find()->where(['>',"create_time",$dayTime])->count();
                       $count+=1;
                       $countStr="0000".$count;
                       //取后面五位数
                       $countStr=substr($countStr,-5);
                       $good->sn=date('Ymd').$countStr;
//                       var_dump($good->sn);exit;
                   }
//                     var_dump($good->images);exit;


                  if($good->save(false)){
                      //内容绑定
                       $goodsIntro->load($request->post());
                         //给文章id赋值
                          $goodsIntro->goods_id=$good->id;
                          //保存数据
                          if($goodsIntro->save()){
                              //变量图片
                              foreach ($good->images as $image){
                                 $gallery= new  GoodsGallery();
                                 $gallery->goods_id=$good->id;
                                 $gallery->path=$image;
                                 //保存
                                 $gallery->save();

                              }
                              \Yii::$app->session->setFlash("success","添加成功");
                              return $this->redirect(["index"]);

                          }
                  }

             }else{
                 var_dump($good->errors);exit;
             }
         }
         return $this->render("add",compact("good",'catesArr','brandsArr','goodsIntro'));
    }

    //编辑
    public  function  actionEdit($id){
        $good=Goods::findOne($id);
        //声明一个goods_intro
        $goodsIntro=GoodsIntro::findOne(["goods_id"=>$id]);
        //查找categoryDepth=2
        $cates=Category::find()->orderBy('tree,lft')->all();
        $catesArr=ArrayHelper::map($cates,'id','nameText');

        //查找brand
        $brands=Brand::find()->all();
        $brandsArr=ArrayHelper::map($brands,'id','name');

        $request=\Yii::$app->request;
        if ($request->isPost){
            //给货物绑定数据
            $good->load($request->post());
            if($good->validate()){

                //判断sn是否有值
                if(!$good->sn){
                    //当天时间戳
                    $dayTime=strtotime(date("Ymd"));
                    //找出当日的商品数量
                    $count=Goods::find()->where(['>',"create_time",$dayTime])->count();
                    $count+=1;
                    $countStr="0000".$count;
                    //取后面五位数
                    $countStr=substr($countStr,-5);
                    $good->sn=date('Ymd').$countStr;
//                       var_dump($good->sn);exit;
                }
//                     var_dump($good->images);exit;


                if($good->save(false)){
                    //内容绑定
                    $goodsIntro->load($request->post());
                    //给文章id赋值
                    $goodsIntro->goods_id=$good->id;
                    //保存数据
                    if($goodsIntro->save()){
                        //删除商品对应的所有图片
                        GoodsGallery::deleteAll(['goods_id'=>$id]);
                        //遍历图片
                        foreach ($good->images as $image){
                            $gallery= new  GoodsGallery();
                            $gallery->goods_id=$good->id;
                            $gallery->path=$image;
                            //保存
                            $gallery->save();

                        }
                        \Yii::$app->session->setFlash("success","添加成功");
                        return $this->redirect(["index"]);

                    }
                }

            }else{
                var_dump($good->errors);exit;
            }
        }
        //找商品对于的图片
         $images=GoodsGallery::find()->where(["goods_id"=>$id])->all();
        //把二维数组转换成一维
        $images=array_column($images,'path');
        //给images赋值
        $good->images=$images;
        return $this->render("add",compact("good",'catesArr','brandsArr','goodsIntro'));
    }

    //删除
    public  function  actionDel($id){
        if(Goods::findOne($id)->delete()){
            GoodsIntro::findOne(["goods_id"=>$id])->delete();
            GoodsGallery::deleteAll(["goods_id"=>$id]);
            \Yii::$app->session->setFlash("success","删除成功");
            return $this->redirect(["index"]);
        }
    }
}
