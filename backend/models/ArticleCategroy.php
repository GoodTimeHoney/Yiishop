<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_categroy".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $introduce 简历
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $is_help 是否帮助
 */
class ArticleCategroy extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','status','sort'], 'required'],
            [['sort','is_help'],'integer'],
            ["introduce","safe"],
            ['name','unique'],
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
            'introduce' => '简介',
            'sort' => '排序',
            'status' => '状态',
            'is_help' => '帮助状态',
        ];
    }
}
