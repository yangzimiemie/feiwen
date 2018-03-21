<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/21
 * Time: 17:17
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'safe']
        ];
    }
}