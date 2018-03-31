<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use yii\web\Request;

class OrderController extends \yii\web\Controller
{
    public function init(){
        $this->enableCsrfValidation = false;
    }

    /**
     * 订单列表
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest){
           return   $this->redirect(['user/login','url'=>'/order/index']);
        }
        $userId = \Yii::$app->user->id;
        $carts= Cart::find()->where(['user_id'=>$userId])->all();
        $cart = ArrayHelper::map($carts,'goods_id','num');
        $getKey = array_keys($cart);
        $good = Goods::find()->where(['in','id',$getKey])->all();
        $address = Address::find()->all();
//        var_dump($goods);exit;
        return $this->render('index',compact('cart','good','address'));
    }

    public function actionAdd(){
        /**
         * 新增订单
         * 循环商品再去新增商品详情
         * 购买后要减去商品库存
         * 关系到金钱就要用到事务，要么成功要么失败
         */
         $orders = new Order();
         $request = new Request();
         if ($request->isPost){
             $orders->load($request->post());
             if($orders->validate()){
                 if ($orders->save()) {

                 }
             }else{
                 //验证失败
             }
         }
    }
}
