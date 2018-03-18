<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Brand".
 *
 * @property int $id
 * @property string $name 品牌名
 * @property string $logo 品牌logo
 * @property int $sort 品牌排序
 * @property string $status 品牌状态
 * @property string $detail 品牌简介
 */
class Brand extends \yii\db\ActiveRecord
{
    //属性
    public $code;
    public function rules()
    {
        return [
            [['name','status','sort','logo'],'required'],
            [['detail','recycle'],'safe'],
            [['sort'],'integer'],
            [['code'],'captcha','captchaAction' => "brand/code"],
            [['sort','name'],'unique']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名',
            'logo' => '品牌logo',
            'sort' => '品牌排序',
            'status' => '品牌状态',
            'detail' => '品牌简介',
            'recycle'=>'删除状态'
        ];
    }
}
