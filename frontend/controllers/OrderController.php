<?php

namespace frontend\controllers;

use backend\models\Delivery;
use backend\models\Goods;
use backend\models\OrderDetail;
use backend\models\Payment;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Js\Js;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\rbac\Role;
use yii\web\Request;
use Endroid\QrCode\QrCode;


class OrderController extends \yii\web\Controller
{
     public $enableCsrfValidation = false;

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
//                 var_dump( $orders->address_id);exit;
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
                             throw new Exception("缺货");
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
                     'msg'=>'成功啦',
                     'id'=>$orders->id,
                 ];
                 return Json::encode($result);
             } catch(Exception $e) {
                 $transaction->rollBack();
                 $result = [
                     'status'=>0,
                     'msg'=>$e->getMessage(),
                     'id'=>$orders->id,
                 ];
                 return Json::encode($result);
             }
         }
        return $this->render('index',compact('cart','good','address','deliverys','payments','shopNum','shopPrice'));
    }

    public function actionWxPay($id)
    {
        $orders = Order::findOne($id);
//        var_dump($orders);exit;
        //配置
        $options = \Yii::$app->params['wx'];
        $app = new Application($options);
        $payment = $app->payment;
//        var_dump($payment);exit;
        //创建订单
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...NATIVE(扫码支付)
            'body'             => '666',
            'detail'           => '888',
            'out_trade_no'     => $orders->no,
            'total_fee'        => 1, // 单位：分
            'notify_url'       =>  Url::to(['order/notify'], true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
//            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order = new \EasyWeChat\Payment\Order($attributes);
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {

        }
//        var_dump($result);exit;
    return $this->render('order',compact('orders','result'));
  }
    public function actionNotify(){
    $options = \Yii::$app->params['wx'];
    $app = new Application($options);
    $response = $app->payment->handleNotify(function($notify, $successful){
        // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
//        $order = 查询订单($notify->out_trade_no);
          $order = Order::findOne(['no'=>$notify->out_trade_no]);
//          var_dump($order);exit;
        if (!$order) { // 如果订单不存在
            return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
        }
        // 如果订单存在
        // 检查订单是否已经更新过支付状态
        if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
            return true; // 已经支付成功了就不再更新了
        }
        // 用户是否支付成功
        if ($successful) {
            // 不是已经支付状态则修改为已经支付状态
//            $order->paid_at = time(); // 更新支付时间为当前时间
            $order->status = 2;
        }
        $order->save(); // 保存订单
        return true; // 返回处理完成
    });
    return $response;
}
    public function actionTest($result){
        $qrCode = new QrCode($result);
        header('Content-Type: '.$qrCode->getContentType());
        echo  $qrCode->writeString();
    }


    public function actionStatus($id)
    {
        $orders = Order::findOne($id);
//        var_dump($orders);exit;
        $rst = [
            'status'=>$orders->status,
            'msg'=>'成功',
            'id'=>$orders->id,
        ];
        return Json::encode($rst);
    }

    /**
     * 超时订单
     */
    public function actionOrder(){
        //找出超时的订单，设置十分钟后取消订单
        $timeOrder = Order::find()->where(['status'=>1])->andWhere(["<","create_time",time()-600])->asArray()->all();
//        var_dump($timeOrder);
        $orderId = array_column($timeOrder,'id');
//        var_dump($orderId);
        Order::updateAll(['status'=>0],['id'=>$orderId]);//修改十分钟之类过期的订单
        foreach ($timeOrder as $order){
            $orderDetail = OrderDetail::find()->where(['id'=>$order->order_id])->all();
            foreach ($orderDetail as $detail){
                Order::updateAllCounters(['stock'=>$detail->num],['id'=>$detail->goods_id]);
            }
        }
    }

    public function actionDetail(){
        $userId = \Yii::$app->user->id;
        $detail = OrderDetail::find()->where(['user_id'=>$userId])->all();
        $orders = Order::find()->where(['user_id'=>$userId])->all();
        return $this->render('detail',compact('detail','orders'));
    }
}
