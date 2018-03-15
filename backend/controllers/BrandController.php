<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{



    //线上列表
    public function actionIndex()
    {
        $sta=["下线","上线"];
        $query=Brand::find();

        $count=$query->count();//得到总条数

        // 使用总数来创建一个分页对象
        $page = new Pagination([
            "pageSize"=>4,//每页现实条数
            "totalCount" => $count ,//总条数

        ]);
        //查数据
        $brands=$query->offset($page->offset)->limit($page->limit)->all();
        //现实视图
        return $this->render("index",compact("brands","page",'sta'));
    }




    //添加方法
    public  function  actionAdd(){
        //实例化brandmodel
        $brand=new  Brand();
        //实例化request
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            //绑定数据
            $brand->load($request->post());
             //得到图片上传文件
            $brand->imgFile=UploadedFile::getInstance($brand,'imgFile');
//            var_dump($brand->imgFile);exit;
            //定义一个空字符串
            $imgPath="";
            //判断图片是否存在
            if($brand->imgFile!==null){
                //定义保存路径
                $imgPath="images/".time().".".$brand->imgFile->extension;
                //移动到imgPath中
                $brand->imgFile->saveAs($imgPath,false);
            }

            //后台验证
            if($brand->validate()){
                //给logo赋值
                $brand->logo=$imgPath;
                   //保存数据
                if ($brand->save(false)) {
                      //保存成功
                    \Yii::$app->session->setFlash("success","添加成功");
                    //跳转页面
                    return $this->redirect(["index"]);
                }
            }else{
                //打印错误
                //TODO
                var_dump($brand->errors);exit;
            }
        }
        //线上和分配视图
        return $this->render("add",compact("brand"));
    }



    //数据编辑
    public  function  actionEdit($id){
        //实例化brandmodel
        $brand=Brand::findOne($id);
        //实例化request
        $request=\Yii::$app->request;
        //判断提交方式
        if($request->isPost){
            //绑定数据
            $brand->load($request->post());

            //得到图片上传文件
            $brand->imgFile=UploadedFile::getInstance($brand,'imgFile');
//            var_dump($brand->imgFile);exit;
            //定义一个空字符串
            $imgPath="";
            //判断图片是否存在
            if($brand->imgFile!==null){
                //定义保存路径
                $imgPath="images/".time().".".$brand->imgFile->extension;
                //移动到imgPath中
                $brand->imgFile->saveAs($imgPath,false);
            }

            //后台验证
            if($brand->validate()){
                if($imgPath){
                    //给logo赋值
                    $brand->logo=$imgPath;
                }
                //保存数据
                if ($brand->save(false)) {
                    //保存成功
                    \Yii::$app->session->setFlash("success","添加成功");
                    //跳转页面
                    return $this->redirect(["index"]);
                }
            }else{
                //打印错误
                //TODO
                var_dump($brand->errors);exit;
            }
        }
        //线上和分配视图
        return $this->render("add",compact("brand"));
    }

    //删除
    public  function  actionDel($id){
        if(Brand::findOne($id)->delete()){
            //跳转到现实界面
            return $this->redirect(["index"]);
        }
    }
}
