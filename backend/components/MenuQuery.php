<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/18
 * Time: 11:42
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsQueryBehavior;

class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}