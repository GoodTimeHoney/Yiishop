<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property int $id
 * @property int $goods_id
 * @property string $path
 */
class GoodsGallery extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['goods_id','path'], 'safe'],


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
            'path' => 'Path',
        ];
    }
}
