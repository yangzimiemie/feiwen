<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods_detail".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $details 商品详情
 */
class GoodsDetail extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['details'], 'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'details' => '商品详情',
        ];
    }
}
