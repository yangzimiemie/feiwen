<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $goods_id 商品ID
 * @property string $name 收货人姓名
 * @property string $province 省级
 * @property string $city 市级
 * @property string $county 区县
 * @property string $address 详细地址
 * @property int $mobile 手机号码
 * @property string $mode 配送方式
 * @property string $freight 运费
 * @property int $no 交易号
 * @property string $amount 商品金额
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $status 状态
 * @property int $total 总计
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'goods_id' => '商品ID',
            'name' => '收货人姓名',
            'province' => '省级',
            'city' => '市级',
            'county' => '区县',
            'address' => '详细地址',
            'mobile' => '手机号码',
            'mode' => '配送方式',
            'freight' => '运费',
            'no' => '交易号',
            'amount' => '商品金额',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '状态',
            'total' => '总计',
        ];
    }
}
