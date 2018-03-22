<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/22
 * Time: 22:30
 */

namespace backend\controllers;


use yii\web\Controller;

class RoleController extends Controller
{
    /**
     * 显示列表
     * @return string
     */
    public function actionIndex(){
        /**
         *   1.实列化组件
         *   2.显示视图
         *   3.获取角色
         */
        $auth = \yii::$app->authManager;
        $role = $auth->getRoles();
        return $this->render('index',compact('role'));
    }

    public function actionAdd(){

    }
}