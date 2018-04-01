<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pay_goods".
 *
 * @property int $id
 * @property string $pay_way 支付方式
 * @property string $pay_rule 支付准则
 */
class PayGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_way', 'pay_rule'], 'required'],
            [['pay_way', 'pay_rule'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_way' => '支付方式',
            'pay_rule' => '支付准则',
        ];
    }
}
