<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $user_name 用户名
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $address 详细地址
 * @property string $mobile 电话
 * @property int $状态 状态
 */
class Address extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'province', 'city', 'area', 'address', 'mobile'], 'required'],
            [['status'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'user_name' => '用户名',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address' => '详细地址',
            'mobile' => '电话',
            'status' => '状态',
        ];
    }
}
