<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;//密码
    public $rePassword;//确认密码
    public $code;//验证码
    public $message;//短信验证码
    public $rememberMe = true;//记住

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

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['password','username','code','rememberMe'];
        $scenarios['reg'] = ['password_hash','username','rePassword','code','email','tel','$message'];
        return $scenarios;
    }
    public function rules()
    {
        return [
            [['username', 'password','rePassword','tel','email','message'], 'required','on' => 'reg'],
            [['username', 'password'], 'required','on' => 'login'],
            [['username','tel'], 'unique','on' => 'reg'],
            [['email'],'email'],
            [['tel'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机号码'],//正则手机号码
            ['password', 'compare', 'compareAttribute'=>'rePassword','on' => 'reg'],
            [['code'],'captcha','captchaAction' => 'user/code'],//验证码
            [['message'],'validateMessage'],
            [['rememberMe'],'safe','on' => 'login'],


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

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
       return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key===$authKey;
    }
}
