<?php

namespace backend\models;

use app\models\ArticleCategory;
use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $name 文章名
 * @property string $status 文章状态
 * @property string $sort 文章排序
 * @property string $detail 文章简介
 * @property string $title 文章标题
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class Article extends \yii\db\ActiveRecord
{
    //验证码属性
    public $code;
    public function rules()
    {
        return [
            [['name', 'status', 'sort',  'title','category_id'], 'required'],
            [['detail'], 'safe'],
            [['code'],'captcha','captchaAction' => "article/code"],

        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名',
            'status' => '文章状态',
            'sort' => '文章排序',
            'detail' => '文章简介',
            'title' => '文章标题',
            'category_id' => '分类名',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'text' => '文章内容',
        ];
    }
    //文章分类名一对一
    public function getCategory(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'category_id']);
    }

}
