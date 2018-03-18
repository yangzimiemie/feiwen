<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m180316_073931_create_article_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('文章分类名'),
            'status'=>$this->string()->notNull()->comment('文章分类状态'),
            'sort'=>$this->string()->notNull()->comment('文章分类排序'),
            'detail'=>$this->text()->notNull()->comment('文章分类简介'),
            'title'=>$this->string()->notNull()->comment('文章分类标题'),
            'is_help'=>$this->integer()->notNull()->comment('文章分类帮助类')
        ]);
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('文章名'),
            'status'=>$this->string()->notNull()->comment('文章状态'),
            'sort'=>$this->string()->notNull()->comment('文章排序'),
            'detail'=>$this->text()->notNull()->comment('文章简介'),
            'title'=>$this->string()->notNull()->comment('文章标题'),
            'create_time'=>$this->integer()->notNull()->comment('创建时间'),
            'update_time'=>$this->integer()->notNull()->comment('更新时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_category');
        $this->dropTable('article');
    }
}
