<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180331_100423_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->comment('用户ID'),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'name'=>$this->string()->comment('收货人姓名'),
            'province'=>$this->string()->comment('省级'),
            'city'=>$this->string()->comment('市级'),
            'county'=>$this->string()->comment('区县'),
            'address'=>$this->string()->comment('详细地址'),
            'mobile'=>$this->integer()->comment('手机号码'),
            'mode'=>$this->string()->comment('配送方式'),
            'freight'=>$this->decimal()->comment('运费'),
            'no'=>$this->integer()->comment('交易号'),
            'amount'=>$this->string()->comment('商品金额'),
            'create_time'=>$this->integer()->comment('创建时间'),
            'update_time'=>$this->integer()->comment('修改时间'),
        ]);
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'order'=>$this->integer()->comment('订单ID'),
            'num'=>$this->string()->comment('商品数量'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
        $this->dropTable('order_detail');
    }
}
