<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180319_071236_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('商品名'),
            'status'=>$this->integer()->notNull()->comment('商品状态'),
            'sn'=>$this->integer()->notNull()->comment('商品名'),
            'price'=>$this->integer()->notNull()->comment('商品价格'),
            'sort'=>$this->integer()->notNull()->comment('商品排序'),
            'goods_cate_id'=>$this->integer()->notNull()->comment('商品分类ID'),
            'brand'=>$this->string()->notNull()->comment('商品品牌'),
            'create_time'=>$this->integer()->notNull()->comment('商品更新时间'),
            'update_time'=>$this->integer()->notNull()->comment('商品修改时间'),
        ]);
        $this->createTable('goods_detail', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull()->comment('商品ID'),
            'details'=>$this->text()->notNull()->comment('商品详情'),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods');
        $this->dropTable('goods_detail');
    }
}
