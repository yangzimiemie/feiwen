<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_cate`.
 */
class m180318_030857_create_goods_cate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_cate', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('商品分类名'),
            'parent_id'=>$this->integer()->notNull()->defaultValue(0)->comment('商品父级ID'),
            'tree'=>$this->integer()->notNull()->comment('树'),
            'lft'=>$this->integer()->comment('左值'),
            'rgt'=>$this->integer()->comment('右值'),
            'detail'=>$this->string()->comment('简介'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_cate');
    }
}
