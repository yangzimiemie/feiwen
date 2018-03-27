<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/27
 * Time: 9:32
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $code;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'safe'],
            [['code'],'captcha','captchaAction' => 'user/code'],//验证码
        ];
    }
}