<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "shopper".
 *
 * @property int $id
 * @property int $user_id
 * @property int $goods_id
 * @property int $number
 */
class Shopper extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    //2.设置规则
    public  function  rules()
    {
        return [
            [['goods_id','amount',"user_id"],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'goods_id' => 'Goods ID',
            'number' => 'Number',
        ];
    }
}
