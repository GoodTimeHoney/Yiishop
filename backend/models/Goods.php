<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $sn 货物
 * @property string $logo 图标
 * @property int $goods_category_id 商品分类
 * @property int $brand_id 品牌
 * @property string $market_price 市场价格
 * @property string $shop_price 本店价格
 * @property int $stock 库存
 * @property int $is_on_sale 是否上架：1上架，0下架
 * @property int $sort 排序
 * @property int $create_time 录入时间
 */
class Goods extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }

    public  $images;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','market_price','goods_category_id','brand_id','shop_price','stock','is_on_sale','sort'], 'required'],
             [['logo','images'],'safe'],
             [['market_price','shop_price'],'number'],
             ['sn','unique'],
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
            'sn' => '货号',
            'logo' => '图标',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架：1上架，0下架',
            'sort' => '排序',
            'create_time' => '录入时间',
        ];
    }


    //建立brand关系
    public  function  getBrand(){
        return $this->hasOne(Brand::className(),["id"=>"id"]);
    }

    //建立brand关系
    public  function  getCate(){
        return $this->hasOne(Category::className(),["id"=>"id"]);
    }
}
