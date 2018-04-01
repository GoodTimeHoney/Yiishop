<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "send_goods".
 *
 * @property int $id
 * @property string $send_way 运送方式
 * @property string $send_money 运送价格
 * @property string $send_rule 运送规则
 */
class SendGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'send_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['send_way', 'send_money', 'send_rule'], 'required'],
            [['send_money'], 'number'],
            [['send_way', 'send_rule'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'send_way' => '运送方式',
            'send_money' => '运送价格',
            'send_rule' => '运送规则',
        ];
    }
}
