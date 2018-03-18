<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property int $id 文章内容ID
 * @property string $content 文章内容
 * @property int $article_id 文章id
 */
class ArticleContent extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['text'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章内容ID',
            'text' => '文章内容',
            'article_id' => '文章id',
        ];
    }
}
