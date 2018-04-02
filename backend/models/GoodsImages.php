<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_images".
 *
 * @property int $id
 * @property int $goods_id
 * @property string $images
 */
class GoodsImages extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['images'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'images' => 'Images',
        ];
    }
}
