<?php

namespace frontend\controllers;

use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    /**
     * 解决400 CSRF
     */
    public function init(){
        $this->enableCsrfValidation = false;
    }

    /**
     * 验证码
     * @return array
     */
    public function actions()
    {
        return [
            'code' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 3,
                'maxLength' => 3,
                'foreColor' => 0x520000
            ],
        ];
    }

    /**
     * 列表
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 注册
     * @return string
     */
    public function actionReg(){
        $user = new User();
        $request = new Request();
        //判断是否post提交
        if($request->isPost){
             $user->load($request->post());
            if ($user->validate()) {
                $user->password_hash=\yii::$app->security->generatePasswordHash('password');
                $user->auth_key=\yii::$app->security->generateRandomString();
                $user->login_ip=ip2long(\yii::$app->request->userIP);
                if ($user->save(false)) {
                 $result = ['status'=>1,'data'=>$user->errors,'msg'=>'注册成功啦~'];
                 return \yii\helpers\Json::encode($result);
                }
            }else{
                $result = ['status'=>0,'data'=>$user->errors,'msg'=>'注册失败啦~'];
                return \yii\helpers\Json::encode($result);
            }
        }
        //显示视图
        return $this->render('reg');
    }

    /**
     * 短信生成
     * @param $tel
     */
    public function actionSendSms($tel){
        /*
         * 生成验证码随机六位
         * 将验证码发送给手机
         * 将验证码存于session，手机号当键。验证码当值
         * 错误的话打印错误信息
         */
        $code = rand(100000,999999);
        $config = [
            'access_key' => 'LTAICIw8JtwoPRoH',
            'access_secret' => '3qD8D4TUEGWBZrbM3wRyjIZOQ67hsH',
            'sign_name' => '菲纹',
        ];
//        $aliSms = new Mrgoon\AliSms\AliSms();
        $aliSms = new AliSms();
        $response = $aliSms->sendSms($tel, 'SMS_128651091', ['code'=> $code], $config);
//        var_dump($response);exit;
        if ($response->Message=="OK"){
            $session = \yii::$app->session;
//        var_dump($session);exit;
            $session->set("tel".$tel,$code);
        }else{
            var_dump($response->Message);
        }

//        return $code;
    }
    public function actionSms($tel,$code){
        //通过手机号取出存在session
        $codeOld = \yii::$app->session->get("tel".$tel);
        //判断验证码是否正确
        if($code==$codeOld){
            echo "ok";
        }else{
            echo "no";
        }

    }
}
