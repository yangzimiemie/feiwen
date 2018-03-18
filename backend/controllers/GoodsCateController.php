<?php

namespace backend\controllers;

use backend\models\GoodsCate;
use creocoder\nestedsets\NestedSetsBehavior;
use PHPUnit\Util\Log\JSON;
use yii\web\Request;
class GoodsCateController extends \yii\web\Controller
{
    /**
     * 显示列表
     * @return string
     */
    public function actionIndex()
    {
        $cate = GoodsCate::find()->orderBy("tree,lft")->all();
        return $this->render('index',compact('cate'));
    }

    /**
     * 添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        $cate = new GoodsCate();
        //找到全部（是数组用asArray）
        $cateArr = GoodsCate::find()->asArray()->all();
        $cateArr[]=["id"=>0,"name"=>"一级分类",'parent_id'=>0];
        $cateJson =\yii\helpers\Json::encode($cateArr);
        $rst = new Request();
        //判断post提交
        if ($rst->isPost) {
            //绑定数据
            $cate->load($rst->post());
          //后台验证
            if ($cate->validate()) {
                //判断父级ID为0是，为一级分类
                if($cate->parent_id==0){
                    //一级
                    $cate->makeRoot();
                    //提示
                    \yii::$app->session->setFlash('success',"添加一级分类~:".$cate->name."成功");
                    //返回继续添加
                    return $this->refresh();
                }else{
                    //先要找到父级对象
                    $parentObj = GoodsCate::findOne($cate->parent_id);
                    //二级分类
                    $cate->prependTo($parentObj);
                    //提示
                    \yii::$app->session->setFlash('success',"添加{$parentObj->name}子分类~:".$cate->name."成功");
                    //返回继续添加
                    return $this->refresh();
                }
                //保存数据
            }else{
                var_dump($cate->errors);exit;
            }
        }
        //显示视图
        return $this->render('add',compact('cate','cateJson'));
    }

    /**
     * 修改
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
       $cate = GoodsCate::findOne($id);
        //找到全部（是数组用asArray）
        $cateArr = GoodsCate::find()->where(['and',['!=','parent_id',$cate->parent_id],["!=",'tree',$cate->tree]])->asArray()->all();
        $cateArr[]=["id"=>0,"name"=>"一级分类",'parent_id'=>0];
        $cateJson =\yii\helpers\Json::encode($cateArr);
        $rst = new Request();
        //判断post提交
        if ($rst->isPost) {
            //绑定数据
            $cate->load($rst->post());
            //后台验证
            if ($cate->validate()) {
                //判断父级ID为0是，为一级分类
                if($cate->parent_id==0){
                    //一级
                    $cate->makeRoot();
                    //提示
                    \yii::$app->session->setFlash('success',"添加一级分类~:".$cate->name."成功");
                    //返回继续添加
                    return $this->refresh();
                }else{
                    //先要找到父级对象
                    $parentObj = GoodsCate::findOne($cate->parent_id);
                    //二级分类
                    $cate->prependTo($parentObj);
                    //提示
                    \yii::$app->session->setFlash('success',"添加{$parentObj->name}子分类~:".$cate->name."成功");
                    //返回继续添加
                    return $this->refresh();
                }
                //保存数据
            }else{
                var_dump($cate->errors);exit;
            }
        }
        //显示视图
        return $this->render('edit',compact('cate','cateJson'));
    }

    public function actionDel($id){
        $cate = GoodsCate::findOne($id);
        $catess =GoodsCate::find()->where(['and',['>','lft',$cate->lft],['=','tree',$cate->tree],['>','depth',$cate->depth]])->all();
        if(!$catess) {
            $cate->delete();
            return $this->redirect('index');
        }else{
            \yii::$app->session->setFlash('danger','失败');
            //返回继续添加
            return $this->redirect('index');
        }
    }
}
