<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property int $user_id 会员id
 * @property string $name 收货人
 * @property string $province 省份
 * @property string $city 城市
 * @property string $area 区县
 * @property string $detail_address 详细地址
 * @property string $tel 手机号
 * @property int $delivery_id 配送方式的ID
 * @property string $delivery_name 配送方式的名字
 * @property string $delivery_price 运费
 * @property int $pay_type_id 支付方式
 * @property string $pay_type_name 支付方式名字
 * @property string $price 商品金额
 * @property int $status 订单状态：0已取消 2代发货 3待收货 4完成
 * @property string $trade_no 订单编号
 * @property string $create_time 生成时间
 */
class Order extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '会员id',
            'name' => '收货人',
            'province' => '省份',
            'city' => '城市',
            'area' => '区县',
            'detail_address' => '详细地址',
            'tel' => '手机号',
            'delivery_id' => '配送方式的ID',
            'delivery_name' => '配送方式的名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式',
            'pay_type_name' => '支付方式名字',
            'price' => '商品金额',
            'status' => '订单状态：0已取消 2代发货 3待收货 4完成',
            'trade_no' => '订单编号',
            'create_time' => '生成时间',
        ];
    }
}
