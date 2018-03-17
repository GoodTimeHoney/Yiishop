<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property int $id
 * @property string $detail 文章内容
 * @property int $article_id 文章id
 */
class ArticleContent extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail'], 'required'],
           // [['article_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detail' => '文章内容',
            'article_id' => '文章id',
        ];
    }
}
