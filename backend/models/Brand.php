<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $logo 头像
 * @property int $sort 排序
 * @property int $status 状态
 * @property string $intro 简历
 */
class Brand extends \yii\db\ActiveRecord
{
      //定义一个文件属性
    public  $imgFile;
    //public  $code;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',"sort","status"], 'required'],
            ["imgFile","image","extensions" => ['jpg','gif','png']],
            ["intro","safe"],

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
            'logo' => '头像',
            'sort' => '排序',
            'status' => '状态',
            'intro' => '简历',
            'imgFile' => '图片',
        ];
    }
}
