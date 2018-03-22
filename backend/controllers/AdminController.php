<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\web\Request;
use yii\data\Pagination;
class AdminController extends CommenController
{
    /**
     * 分页列表
     * @return string
     */
    public function actionIndex()
    {
        $query = Admin::find()->orderBy('id desc');
        //获取数据的条数
        $count = $query->count();
        //创建一个分页的对象
        $pages = new Pagination(['pageSize' => 3,'totalCount' => $count]);//每页的显示条数和总共的条数
        //查数据
        $admin = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',compact('admin','pages'));
    }

    /**
     * 添加方法
     * @return \yii\web\Response
     */
    public function actionAdd(){
        $admin = new Admin();
        $admin->setScenario('add');
        $request = \yii::$app->request;
        if($request->isPost){
            $admin->load($request->post());
            if ($admin->validate()) {
                $admin->password_hash=\yii::$app->security->generatePasswordHash($admin->password_hash);
                $admin->auth_key=\yii::$app->security->generateRandomString();
                $admin->login_ip=ip2long(\yii::$app->request->userIP);
//                $admin->login_ip=long2ip(\yii::$app->request->userIP);
                if ($admin->save()) {
                    \yii::$app->session->setFlash('success','登录成功');
                    return $this->redirect('index');
                }
            }else{
                //TODO
               var_dump($admin->errors);exit;
            }
        }
      return  $this->render('add',compact('admin'));
    }

    /**
     * 修改
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        $admin = Admin::findOne($id);
        $password=$admin->password_hash;
        $request = \yii::$app->request;
        $admin->setScenario('edit');
        if($request->isPost){
            $admin->load($request->post());
            if ($admin->validate()) {
//                if($admin->password_hash) {
//                    $admin->password_hash = \yii::$app->security->generatePasswordHash($admin->password_hash);
//                }else{
//
//                }

                $admin->password_hash=$admin->password_hash!==""?\yii::$app->security->generatePasswordHash($admin->password_hash):$password;

                if ($admin->save()) {
                    \yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect('index');
                }
            }else{
                var_dump($admin->errors);exit;
            }
        }
        return  $this->render('edit',compact('admin'));
    }

    /**
     * 登录
     * @return string|\yii\web\Response
     */
  public function actionLogin(){
        //判断用户有没有登录
      if (!\yii::$app->user->isGuest) {
          return $this->redirect('index');
      }
      $model = new LoginForm();
      $request = new Request();
      if ($request->isPost){
          $model->load($request->post());
          if ($model->validate()) {
              $admin = Admin::findOne(['username'=>$model->username]);
              //判断用户是否存在
              if($admin && $admin->status==10){
                  if (\yii::$app->security->validatePassword($model->password,$admin->password_hash)) {
                        //密码正确就用user组件登录
                     \yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);//记住
                     //修改登录的时间和IP
                      $admin->login_ip=ip2long(\yii::$app->request->userIP);
                      $admin->login_time=time();
                      $admin->save();
                     \yii::$app->session->setFlash('success','登录成功');
                     return $this->redirect('index');

                  }else{
                      $model->addError('password','密码不正确');
                  }
              } $model->addError('username','用户名或者状态被禁用');
          }else{

          }
      }
      return $this->render('login',compact('model'));
  }

    /**
     * 退出
     * @return \yii\web\Response
     */
  public function actionLogout(){
      \yii::$app->user->logout();
      return $this->redirect('login');
  }

  public function actionDel($id){
      if (Admin::findOne($id)->delete()) {
         return $this->redirect('index');
      }
  }

    /**
     * 测试密码
     */
  public function actionTest(){
      var_dump(\yii::$app->security->validatePassword('111','$2y$13$qhja93PgtUATM8..8fvxrOwixRL0k1yYfirENXYRk.D0XFJBtZxAu'));
  }
}
