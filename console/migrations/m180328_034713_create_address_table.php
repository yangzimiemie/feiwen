<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m180328_034713_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull()->comment('用户id'),
            'name'=>$this->string()->notNull()->comment('收货人姓名'),
            'province'=>$this->string()->comment('省级'),
            'city'=>$this->string()->comment('市级'),
            'county'=>$this->string()->comment('区县'),
            'address'=>$this->string()->comment('详细地址'),
            'mobile'=>$this->string()->comment('手机号码'),
            'status'=>$this->smallInteger()->defaultValue(0)->comment('是否为默认地址'),
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('address');
    }
}
