<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mulu".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $icon 图标
 * @property string $url 地址
 * @property int $parent_id 父类id
 */
class Mulu extends \yii\db\ActiveRecord
{



    public function rules()
    {
        return [
            [['name', 'icon', 'url', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['name', 'icon', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'icon' => '图标',
            'url' => '地址',
            'parent_id' => '父类id',
        ];
    }

     //声明一个静态方法
    public  static function menu(){
        //定义一个空数组来装菜单
        $menu=[];
          //得到一及目录
       $menusOne=self::find()->where("parent_id=0")->all();
       foreach ($menusOne as $menuOne){
           $newMenu=[];
           $newMenu["label"]=$menuOne->name;
           $newMenu["icon"]=$menuOne->icon;
           $newMenu["url"]=$menuOne->url;

           //通过一级菜单找二级菜单
           $menusTwo=self::find()->where(["parent_id"=>$menuOne->id])->all();
           foreach ($menusTwo as $menuTwo){
               $newMenuSon=[];
               $newMenuSon["label"]=$menuTwo->name;
               $newMenuSon["icon"]=$menuTwo->icon;
               $newMenuSon["url"]=$menuTwo->url;
               $newMenu["items"][]=$newMenuSon;
           }
           $menu[]=$newMenu;
       }
      return $menu;
    }
}
