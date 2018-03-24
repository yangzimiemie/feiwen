<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/22
 * Time: 22:30
 */

namespace backend\controllers;


use backend\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
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

    /**
     * 添加角色
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        /*
        1.先实列组件
        2.展示视图
        3.创建角色
          设置描述
          添加到库中
        */
        $role = new AuthItem();
        $auth = \yii::$app->authManager;
        //得到所有的权限
        $per= $auth->getPermissions();
        $persArr = ArrayHelper::map($per,'name','description');
       //绑定数据并进行验证
        if($role->load(\yii::$app->request->post()) && $role->validate()){
            //创建角色
            $createRole = $auth->createRole($role->name);
            //描述
            $createRole->description=$role->description;
            //添加到库中去
            if($auth->add($createRole)){
                //判断有没有添加权限
                if($role->permission){
                    //循环并且将权限加入到角色
                    foreach($role->permission as $perName){
                        //找到权限并获得权限名
                        $per = $auth->getPermission($perName);
                        //给角色添加权限
                        $auth->addChild($createRole,$per);
                    }
                }
                //提示
                \yii::$app->session->setFlash('success',"添加".$role->name."成功");
                return $this->refresh();
            }
        }
        return $this->render('add',compact('role','persArr'));
    }

    /**
     * 修改角色
     * @param $name
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        $role = AuthItem::findOne($name);
        $auth = \yii::$app->authManager;
        //得到所有的权限
        $per= $auth->getPermissions();
        $persArr = ArrayHelper::map($per,'name','description');
        //先得到权限角色名
       $rolePers = $auth->getPermissionsByRole($name);
        $role->permission=array_keys($rolePers);
        //绑定数据并进行验证
        if($role->load(\yii::$app->request->post()) && $role->validate()){
            //创建角色
            $createRole = $auth->getRole($role->name);
            //描述
            $createRole->description=$role->description;
            //添加到库中去
            if($auth->update($name,$createRole)){
                //需要删除角色当前的权限
                $auth->removeChildren($createRole);
                //判断有没有添加权限
                if($role->permission){
                    //循环并且将权限加入到角色
                    foreach($role->permission as $perName){
                        //找到权限并获得权限名
                        $per = $auth->getPermission($perName);
                        //给角色添加权限
                        $auth->addChild($createRole,$per);
                    }
                }
                //提示
                \yii::$app->session->setFlash('success',"添加".$role->name."成功");
                return $this->redirect('index');
            }
        }
        return $this->render('edit',compact('role','persArr'));
    }

    /**
     * 删除角色
     * @param $name
     * @return \yii\web\Response
     */
    public function actionDel($name){
        $auth = \yii::$app->authManager;
        //找到角色
        $role = $auth->getRole($name);
        //删除
        if ($auth->remove($role)) {
            return $this->redirect('index');
        }
    }

    //用户添加到角色
    public function actionAdminRole($roleName,$id){
        //实列化组件
        $auth = \yii::$app->authManager;
        //找到角色
        $role = $auth->getRole($roleName);
        //指派
        $auth->assign($role,$id);
    }

    //测试是否有权限
//    public function actionCheck(){
//      var_dump(\yii::$app->user->can('brand/index'));
//    }
}