<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $auth_key 令牌
 * @property string $password_hash 密码
 * @property string $password_reset_token 确认密码
 * @property string $email 邮箱
 * @property int $status 状态
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $login_ip 登录IP
 * @property int $login_time 登录时间
 * @property string $tel 电话
 */
class User extends \yii\db\ActiveRecord
{
    public $password;//密码
    public $rePassword;//确认密码
    public $code;//验证码
    public $message;//短信验证码

    /**
     * 时间注入行为
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password','rePassword','tel','email'], 'required'],
            [['username','tel'], 'unique'],
            [['email'],'email'],
            [['tel'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机号码'],//正则手机号码
            ['password', 'compare', 'compareAttribute'=>'rePassword'],
            [['code'],'captcha','captchaAction' => 'user/code'],//验证码
            [['message'],'validateMessage']


        ];
    }
    public function validateMessage($attribute,$params){
         //获取之前存在session的验证码
        $coded = \yii::$app->session->get("tel".$this->tel);
        //判断验证码是否正确
        if($this->message!=$coded){
             $this->addError($attribute,'验证码错误');
        }
//        var_dump($coded);exit;
        //判断验证码是否正确
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '令牌',
            'password_hash' => '密码',
            'password_reset_token' => '确认密码',
            'email' => '邮箱',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'login_ip' => '登录IP',
            'login_time' => '登录时间',
            'tel' => '电话',
        ];
    }
}
