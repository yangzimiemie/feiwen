<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $name 收货人姓名
 * @property string $province 省级
 * @property string $city 市级
 * @property string $county 区县
 * @property string $address 详细地址
 * @property string $mobile 手机号码
 * @property int $status 是否为默认地址
 */
class Address extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [[ 'name','province','city','county','address','mobile'], 'required'],
            [['status'],'safe'],
            [['mobile'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机号码'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'name' => '收货人姓名',
            'province' => '省级',
            'city' => '市级',
            'county' => '区县',
            'address' => '详细地址',
            'mobile' => '手机号码',
            'status' => '是否为默认地址',
        ];
    }
}
