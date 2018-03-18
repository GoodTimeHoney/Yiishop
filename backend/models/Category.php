<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Symfony\Component\CssSelector\Tests\Node\NegationNodeTest;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $tree 分类
 * @property int $lft 左值
 * @property int $rgt 右值
 * @property int $depth 深度
 * @property string $name 名称
 * @property string $introduce 简介
 * @property int $parend_id 父级id
 */
class Category extends \yii\db\ActiveRecord
{



    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }


    public function rules()
    {
        return [
            [[ 'name','parend_id'], 'required'],
            ["introduce",'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => '分类',
            'lft' => '左值',
            'rgt' => '右值',
            'depth' => '深度',
            'name' => '名称',
            'introduce' => '简介',
            'parend_id' => '父级id',
        ];
    }
}
