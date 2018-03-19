<?php

namespace app\models;

use backend\models\GoodsCate;
use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 商品名
 * @property int $status 商品状态
 * @property int $sn 商品名
 * @property int $price 商品价格
 * @property int $sort 商品排序
 * @property int $goods_cate_id 商品分类ID
 * @property string $brand 商品品牌
 * @property int $create_time 商品更新时间
 * @property int $update_time 商品修改时间
 */
class Goods extends \yii\db\ActiveRecord implements \vintage\search\interfaces\SearchInterface
{
    public $img;
    public function rules()
    {
        return [
            [['name', 'status', 'brand','sn','goods_cate_id','logo'], 'required'],
            [['sort'],'integer'],
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
            'goods_cate_id' => '商品分类ID',
            'brand' => '商品品牌',
            'create_time' => '商品更新时间',
            'update_time' => '商品修改时间',
        ];
    }
public function getGoodsCate(){
        return $this->hasOne(GoodsCate::className(),['id'=>'goods_cate_id']);
}

    /**
     * Gets title.
     *
     * @return string This string will be inserted to the search result
     * to `title` field.
     */
    public function getSearchTitle()
    {
        return $this->title;
    }

    /**
     * Gets description.
     *
     * @return string This string will be inserted to the search result
     * to `description` field.
     */
    public function getSearchDescription()
    {
        return $this->short_description;
    }

    /**
     * Gets routes.
     *
     * @return string This string will be inserted to the search result
     * to `url` field.
     */
    public function getSearchUrl()
    {
        return Url::toRoute(['/news/default/index', 'id' => $this->id]);
    }

    /**
     * @return string[] Array of the field names
     * where will be implemented search in model.
     */
    public function getSearchFields()
    {
        return [
            'title',
            'short_description',
            'content',
        ];
    }
}
