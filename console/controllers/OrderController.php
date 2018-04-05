<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/4/5
 * Time: 22:33
 */

namespace console\controllers;


use backend\models\OrderDetail;
use frontend\models\Order;
use yii\console\Controller;

class OrderController extends Controller
{
    public function actionClear(){
        while (true){
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

                echo "completed ";

            sleep(1);
        }

    }
}