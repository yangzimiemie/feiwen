<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    /**
     * 列表
     * @return string
     */
    public function actionIndex()
    {
        //实列化组件
        $auth = \yii::$app->authManager;
        //获取权限
        $per = $auth->getPermissions();
//        echo "<pre/>";
//        var_dump($per);exit;
        return $this->render('index',compact('per'));
    }

    /**
     * 权限的添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建Authitem对象
        $per = new AuthItem();
        //1.实列化组件
        $amg = \yii::$app->authManager;
        //判断是不是post提交并且进行验证
        if($per->load(\yii::$app->request->post()) && $per->validate()){
            //创建权限
            $permission = $amg->createPermission($per->name);
            //设置描述
            $permission->description=$per->description;
            //添加到库中
            if($amg->add($permission)){
                \yii::$app->session->setFlash('success', "添加权限" . $per->name . "成功");
                return $this->refresh();
            }
        }
        return $this->render('add',compact('per'));
    }

    /**
     * 编辑
     * @param $name   name是主键
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        //创建Authitem对象
        $per = AuthItem::findOne($name);
        //1.实列化组件
        $amg = \yii::$app->authManager;
        //判断是不是post提交并且进行验证
        if($per->load(\yii::$app->request->post()) && $per->validate()){
            //获取权限
            $permission = $amg->getPermission($per->name);
            //判断
            if($permission){
                //设置权限
                $permission->description=$per->description;
                //添加到库中
                if($amg->update($name,$permission)) {
                    \yii::$app->session->setFlash('success', "修改权限");
                    return $this->redirect('index');
                }
            }else{
                \yii::$app->session->setFlash('danger', "不可以修改权限名称");
                return $this->redirect('index');
            }

        }
        return $this->render('edit',compact('per'));
    }

    /**
     * 权限的删除
     * @param $name
     * @return \yii\web\Response
     */
    public function actionDel($name){
            //1.先实列化组件
        $auth = \yii::$app->authManager;
        //2.找到
        $per = $auth->getPermission($name);
        //3.删除
        if ($auth->remove($per)) {
            return $this->redirect('index');
        }
    }
}
