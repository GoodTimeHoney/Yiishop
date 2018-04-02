<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property string $id
 * @property string $order_info_id 订单id
 * @property string $goods_id 商品id
 * @property string $goods_name 商品的名称
 * @property string $logo LOGO
 * @property string $price 价格
 * @property int $amount 数量
 * @property string $total_price 小计
 */
class OrderDetail extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_info_id' => '订单id',
            'goods_id' => '商品id',
            'goods_name' => '商品的名称',
            'logo' => 'LOGO',
            'price' => '价格',
            'amount' => '数量',
            'total_price' => '小计',
        ];
    }
}
