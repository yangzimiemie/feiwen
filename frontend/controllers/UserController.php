<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;
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
        $user->setScenario('reg');
        //判断是否post提交
        if($request->isPost){
            $user->load($request->post());
            if ($user->validate()) {
                $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);
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
     * 登录
     * @return string
     */
    public function actionLogin(){
          /**
           * 先创建模型对象
           * 判断是否post提交
           * 用username去找用户的数据
           * 再去验证用户是否正确
           * 正确验证密码->用组件登录并且记住登录状态，设置过期时间
           * 为ip和时间赋值
           * 保存数据
           */
        //判断用户有没有登录
        if (!\yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
       $login = new User();
       $request = new Request();
       $login->setScenario('login');
       if($request->isPost){
           $login->load($request->post());
           if ($login->validate()) {
              $user = User::findOne(['username'=>$login->username]);
               if($user){
                   if (\Yii::$app->security->validatePassword($login->password,$user->password_hash)) {
                       \yii::$app->user->login($user,$user->rememberMe?3600*24*7:0);
                       $user->login_time=time();
                       $user->login_ip=ip2long(\yii::$app->request->userIP);
                       $user->save(false);
                           $result = [
                               'status'=>1,
                               'data'=>$login->errors,
                               'msg'=>'登录成功啦~'
                           ];
                           return Json::encode($result);
                   }else{
                       $result = [
                           'status'=>0,
                           'data'=>$login->errors,
                           'msg'=>'密码错误~'
                       ];
                       return Json::encode($result);
                   }
               }else{
                   $result = [
                       'status'=>0,
                       'data'=>$login->errors,
                       'msg'=>'用户不存在或状态未激活~'
                   ];
                   return Json::encode($result);
               }
           }else{
               $result = [
                   'status'=>0,
                   'data'=>$login->errors,
                   'msg'=>'登录失败啦~'
               ];
               return Json::encode($result);
           }
       }
        return $this->render('login');
    }

    /**
     * 退出
     * @return \yii\web\Response
     */
    public function actionLogout(){
        \yii::$app->user->logout();
        return $this->redirect('login');
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

    /**
     * 验证验证码是否输入正确
     * @param $tel
     * @param $code
     */
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
