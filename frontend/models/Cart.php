<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property int $user_id 用户ID
 * @property int $num 商品数量
 */
class Cart extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['goods_id', 'user_id', 'num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'user_id' => '用户ID',
            'num' => '商品数量',
        ];
    }
}
