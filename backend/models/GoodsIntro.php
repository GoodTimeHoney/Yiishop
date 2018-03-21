<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_intro".
 *
 * @property int $id
 * @property int $goods_id
 * @property string $content
 */
class GoodsIntro extends \yii\db\ActiveRecord
{


    public function rules()
    {
        return [
            [['content','goods_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'content' => 'Content',
        ];
    }
}
