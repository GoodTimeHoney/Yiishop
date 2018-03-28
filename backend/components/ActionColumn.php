<?php
/**
 * Created by PhpStorm.
 * User: LC
 * Date: 2018/3/27
 * Time: 17:27
 */

namespace backend\components;


class ActionColumn extends \yii\grid\ActionColumn
{

    protected function renderDataCellContent($model, $key, $index)
    {
         $key=$model->id;//修正id
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            }

            return '';
        }, $this->template);
    }
}