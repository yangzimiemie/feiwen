<?php

namespace frontend\controllers;

use backend\models\Delivery;
use backend\models\Goods;
use backend\models\OrderDetail;
use backend\models\Payment;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
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
        $deliverys = Delivery::find()->all();
        $payments = Payment::find()->all();
        $address = Address::find()->where(['user_id'=>$userId])->all();
        $carts= Cart::find()->where(['user_id'=>$userId])->all();
        $cart = ArrayHelper::map($carts,'goods_id','num');
        $getKey = array_keys($cart);
        $good = Goods::find()->where(['in','id',$getKey])->all();
        /**
         * 商品数量和商品价格需要循环
         * 先创建一个商品数量和商品总计的属性
         */
        $shopPrice = 0;
        $shopNum = 0;
        foreach ($good as $row){
            $shopPrice += $row->price*$cart[$row->id];
            $shopNum += $cart[$row->id];
        }
        $shopPrice = number_format($shopPrice,2);
        /**
         * 新增订单
         * 循环商品再去新增商品详情
         * 购买后要减去商品库存
         * 关系到金钱就要用到事务，要么成功要么失败
         */
        $request = \Yii::$app->request;
         if($request->isPost){
             $db = \Yii::$app->db;
             $transaction = $db->beginTransaction();

             try {
                 $orders = new Order();
                 /**
                  * 取出地址
                  * 取出支付和配送方式的地址
                  * 赋值
                  */
                 $addressId = $request->post('address_id');
//                  var_dump($addressId);exit;
                 $address = Address::findOne(['id'=>$addressId,'user_id'=>$userId]);

                 $deliveryId = $request->post('delivery');
                 $deliverys = Delivery::findOne($deliveryId);

                 $payId = $request->post('pay');
                 $payments = Payment::findOne($payId);

                 $orders->user_id = $userId;

                 $orders->name = $address->name;

                 $orders->province = $address->province;
                 $orders->city = $address->city;
                 $orders->county = $address->county;
                 $orders->address = $address->address;
                 $orders->mobile = $address->mobile;

                 $orders->delivery_id = $deliveryId;//配送id
                 $orders->mode = $deliverys->name;//配送方式
                 $orders->freight = $deliverys->price;//运费

                 $orders->payment_id = $payId;//支付ID
                 $orders->pay = $payments->name;//支付名称

                 //总金额
                 $orders->total = $shopPrice+ $deliverys->price;
                 //状态
                 $orders->status = 1;
                 /*
                 随机订单号
                 时间
                 保存数据
                 循环商品
                 判断购物车的商品ID和商品库存是否充足
                 不充足抛出异常
                 */
                 /*
                  * 创建订单详情对象
                  * 赋值
                  * 保存
                  * 减去相应的商品ID库存
                  * 保存减去的
                  */
                 $orders->no = date("ymdHis").rand(1000,9999);
                 $orders->create_time = time();
                 if ($orders->save()) {
                     foreach ($good as $row){
                         $goods = Goods::findOne($row->id);
                         if($cart[$row->id]>$goods->stock){
                             throw new Exception("库存不足");
                         }
                         $orderDetail = new OrderDetail();
                         $orderDetail->goods_id=$goods->id;
                         $orderDetail->order_id=$orders->id;
                         $orderDetail->num=$cart[$row->id];
                         $orderDetail->goods_name=$goods->name;
                         $orderDetail->logo=$goods->logo;
                         $orderDetail->price=$goods->price;
                         $orderDetail->total=$shopPrice*$orderDetail->num;
                         if ($orderDetail->save(false)) {
                            //库存减去商品ID
                             $goods->stock = $goods->stock-$cart[$goods->id];
                             $goods->save(false);
                         }
                     }
                 }
                 Cart::deleteAll(['user_id'=>$userId]);
                 $transaction->commit();//提交事务
                 $result = [
                     'status'=>1,
                     'msg'=>'成功啦'
                 ];
                 return Json::encode($result);
             } catch(Exception $e) {
                 $transaction->rollBack();
                 $result = [
                     'status'=>0,
                     'msg'=>$e->getMessage()
                 ];
                 return Json::encode($result);
             }
         }
        return $this->render('index',compact('cart','good','address','deliverys','payments','shopNum','shopPrice'));
    }

    public function actionOrder(){
        return $this->render('order');
    }

}
