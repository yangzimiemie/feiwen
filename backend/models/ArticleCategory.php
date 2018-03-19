<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property int $id
 * @property string $name 文章分类名
 * @property string $status 文章分类状态
 * @property string $sort 文章分类排序
 * @property string $detail 文章分类简介
 * @property string $title 文章分类标题
 * @property int $is_help 文章分类帮助类
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

    //验证码属性
    public $code;
    public function rules()
    {
        return [
                [['name','title','status','sort','is_help'],'required'],
                [['sort'],'integer'],
                [['detail'],'safe'],
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
            'name' => '文章分类名',
            'status' => '文章分类状态',
            'sort' => '文章分类排序',
            'detail' => '文章分类简介',
            'title' => '文章分类标题',
            'is_help' => '文章分类帮助类',
        ];
    }
}
