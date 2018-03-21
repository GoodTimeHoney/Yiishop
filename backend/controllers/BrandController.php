<?php

namespace backend\controllers;

use backend\models\Brand;
use crazyfd\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{



    //线上列表
    public function actionIndex()
    {
        $sta=["下线","上线"];
        $query=Brand::find()->where(["status"=>1])->orderBy(["sort"=>"desc"]);

        $count=$query->count();//得到总条数

        // 使用总数来创建一个分页对象
        $page = new Pagination([
            "pageSize"=>2,//每页现实条数
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
          /*  $brand->imgFile=UploadedFile::getInstance($brand,'imgFile');
//            var_dump($brand->imgFile);exit;
            //定义一个空字符串
            $imgPath="";
            //判断图片是否存在
            if($brand->imgFile!==null){
                //定义保存路径
                $imgPath="images/".time().".".$brand->imgFile->extension;
                //移动到imgPath中
                $brand->imgFile->saveAs($imgPath,false);
            }*/

            //后台验证
            if($brand->validate()){
                //给logo赋值
              //  $brand->logo=$imgPath;
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

           /* //得到图片上传文件
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
            }*/


            //后台验证
            if($brand->validate()){
                /*if($imgPath){
                    //给logo赋值
                    $brand->logo=$imgPath;
                }*/
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
          $result= Brand::updateAll(["status"=>0],["id"=>$id]);
            //跳转到现实界面
            return $this->redirect(["index"]);

    }

    public  function  actionShow(){
         $brands=Brand::find()->all();

         return $this->render("show",compact("brands"));

    }



    //声明一个webupload方法
    public  function  actionUpload(){

        switch (\Yii::$app->params["uploadType"]){
            case "127.0.0.1":
                //得到文件上传对象
                $getFile=UploadedFile::getInstanceByName("file");
//        var_dump($getFile);
                //移动目录
                if($getFile!==null){
                    //拼路径
                    $imgPath="images/".time().".".$getFile->extension;
                    //移动
                    if ($getFile->saveAs($imgPath,false)) {
                        //正确时
                        $fish=[
                            'code'=>0,
                            'url'=>'/'.$imgPath,
                            'attachment'=>$imgPath
                        ];
                        //返回数据
                        return Json::encode($fish);
                    }
                }else{
                    //错误时
                    $result=[
                        'code'=>1,
                        'msg'=>'error'
                    ];
                    //返回数据
                    return Json::encode($result);
                }
            case "qiuniu":
                $ak = 'TVi3MkdaW5EgHFJsE58GTZfhIL5wBh9J9ZIinBcm'; //应用的ID
                $sk = '-NjZSH7ASFksOB7mp1eavUmvD_K8eaH9YxmHlSQD'; //密钥
                $domain = 'http://p5u7x2bzw.bkt.clouddn.com/';  //地址
                $bucket = 'yiishop'; // 空间名称
                $zone = 'south_china'; //区域
                $qiniu = new Qiniu($ak, $sk, $domain, $bucket, $zone);
                $key = uniqid();
                $key .= strtolower(strrchr($_FILES['file']['name'], '.'));

                $qiniu->uploadFile($_FILES['file']['tmp_name'], $key);
                $url = $qiniu->getLink($key);
//        var_dump($url);exit;
                $fish=[
                    'code'=>0,
                    'url'=>$url,
                    'attachment'=>$url
                ];
                //返回数据
                return Json::encode($fish);

        }

    }




}
