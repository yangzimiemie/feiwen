<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/18
 * Time: 11:44
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