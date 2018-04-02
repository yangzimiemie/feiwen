<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 商品名
 * @property int $status 商品状态
 * @property string $sn 商品名
 * @property string $price 商品价格
 * @property int $sort 商品排序
 * @property int $goods_cate_id 商品分类ID
 * @property int $brand_id 商品品牌
 * @property int $create_time 商品更新时间
 * @property int $update_time 商品修改时间
 * @property string $logo 商品logo
 * @property int $stock 商品库存
 */
class Goods extends \yii\db\ActiveRecord
{
    public $images;
    public function rules()
    {
        return [
            [['name', 'status', 'brand_id','goods_cate_id','logo'], 'required'],
            [['sort','stock'],'integer'],
            [['images','sn',],'safe'],
            [['price'],'double'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名',
            'status' => '商品状态',
            'sn' => '商品货号',
            'price' => '商品价格',
            'sort' => '商品排序',
            'stock' => '商品库存',
            'goods_cate_id' => '商品分类ID',
            'brand' => '商品品牌',
            'create_time' => '商品更新时间',
            'update_time' => '商品修改时间',
        ];
    }
    public function getGoodsCate(){
        return $this->hasOne(GoodsCate::className(),['id'=>'goods_cate_id']);
    }
    public function getBrandName(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    public function getImgs(){
        return $this->hasMany(GoodsImages::className(),['goods_id'=>'id']);
    }
    /**
     * 时间注入行为
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }
}
