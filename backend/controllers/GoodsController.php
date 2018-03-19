<?php

namespace backend\controllers;

use app\models\Goods;
use app\models\GoodsDetail;
use backend\models\GoodsCate;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class GoodsController extends CommenController
{
    /**
     * 商品列表
     * @return string
     */
    public function actionIndex()
    {
        $query = Goods::find()->orderBy('id desc');
        //获取数据的条数
        $count = $query->count();
        //创建一个分页的对象
        $pages = new Pagination(['pageSize' => 3,'totalCount' => $count]);//每页的显示条数和总共的条数
        //查数据
        $goods= $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index',compact('goods','pages'));
    }

    /**
     * 添加方法
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        $goods = new Goods();
        //找到id
        $conts=Goods::find()->count();
        $cates = GoodsCate::find()->all();
        //再把二维的转换为一维
        $catesArr=ArrayHelper::map($cates,'id','name');
        $details = new GoodsDetail();
        $rst = new Request();
        if($rst->isPost){
            $goods->load($rst->post());
            if ($goods->validate()) {
                if ($goods->save()) {
                    //绑定文章详情数据
                    $details->load($rst->post());
                    if ($details->validate()) {
                        if ($details->save()) {
                            //提示
                            \yii::$app->session->setFlash('success','添加成功啦！');
                            //返回列表
                            return $this->redirect('index');
                        }
                    }else{
                        var_dump($details->errors);exit;
                    }
                }
            }else{
                \yii::$app->session->setFlash('name','添加成功啦');
            }
        }
        //显示视图
        return $this->render('add',compact('goods','details','conts','catesArr'));
    }

    public function actionEdit($id){
        $goods=Goods::findOne($id);
        //找到id
        $conts=Goods::find()->count();
        $cates = GoodsCate::find()->all();
        //再把二维的转换为一维
        $catesArr=ArrayHelper::map($cates,'id','name');
        $details = new GoodsDetail();
        $rst = new Request();
        if($rst->isPost){
            $goods->load($rst->post());
            if ($goods->validate()) {
                if ($goods->save()) {
                    //绑定文章详情数据
                    $details->load($rst->post());
                    if ($details->validate()) {
                        if ($details->save()) {
                            //提示
                            \yii::$app->session->setFlash('success','添加成功啦！');
                            //返回列表
                            return $this->redirect('index');
                        }
                    }else{
                        var_dump($details->errors);exit;
                    }
                }
            }else{
                \yii::$app->session->setFlash('name','添加成功啦');
            }
        }
        //显示视图
        return $this->render('add',compact('goods','details','conts','catesArr'));
    }

}
