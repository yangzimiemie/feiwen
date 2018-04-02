<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/29
 * Time: 16:24
 */

namespace frontend\controllers;


use backend\models\Admin;
use backend\models\Goods;
use frontend\components\ShopCart;
use frontend\models\Address;
use frontend\models\Cart;
use function Sodium\add;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Cookie;

class GoodsController extends Controller
{
    /**
     * 解决400 CSRF
     */
    public function init(){
        $this->enableCsrfValidation = false;
        }

    /**
     * 商品详情页面
     * @param $id
     * @return string
     */
    public function actionThumb($id){
    $good = Goods::findOne($id);
    return $this->render('goods',compact('good'));
    }

    /**
     * 购物车
     * @param $id 商品id
     * @param $amount 商品数量
     * @return \yii\web\Response
     */
    public function actionCart($id,$amount){
        if (\Yii::$app->user->isGuest){
            //得到cookie对象
            (new ShopCart())->add($id,$amount)->save();
        }else{
//            登录就存在数据库
            /*
             * 当前用户
             * 当前用户是否有商品id
             * 判断有的就添加没有就新增
             */
            $userId = \Yii::$app->user->id;
            $cart = Cart::findOne(['goods_id'=>$id,'user_id'=>$userId]);
            if($cart){
                $cart->num+=$amount;
            }else{
                $cart = new Cart();
                //赋值
                $cart->goods_id=$id;
                $cart->user_id=$userId;
                $cart->num=$amount;
            }
            $cart->save();
//            (new ShopCart())->synDb()->save();
        }
        return $this->redirect('cart-list');
    }

    /**
     * 购物车列表
     * @return string
     */
    public function actionCartList(){
        /**
         * 判断用户是否登录
         * 从cookie中取出所有购物车数据
         * 在取出所有的key值
         * 取出购物车所有的商品
         */
        if (\Yii::$app->user->isGuest){
            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
            $cookie = array_keys($cart);
            $goods = Goods::find()->where(['in','id',$cookie])->all();
        }else{
            /**
             * 从购物车取出数据
             * 把二维转为一维
             * 获取键值
             * 取出购物车所有商品
             */
            $cart = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
//            var_dump($cart);exit;
            $cart = ArrayHelper::map($cart,'goods_id','num');
            $getKey = array_keys($cart);
            $goods = Goods::find()->where(['in','id',$getKey])->all();
        }
        return $this->render('cart',compact('goods','cart'));
    }

    /**
     * 修改购物车
     * @param $id
     * @param $amount
     */
    public function actionUpdate($id,$amount){

        /**
         * 设个cookie对象
         * new一个cookie对象
         * 添加到cookie
         * 从购物车中取得数据
         * 修改对应的数据
         */
        if (\Yii::$app->user->isGuest) {
            (new ShopCart())->update($id, $amount)->save();
        }else{
            $goods = Cart::findOne(['goods_id'=>$id,'user_id'=>\Yii::$app->user->id]);
            $goods->num = $amount;
            $goods->save();
        }
        return Json::encode([
            'status' => 1,
            'msg' => '修改成功',
        ]);
    }
    /**
     * 删除
     * @param $id
     * @return string
     */
    public function actionDel($id)
    {

        /**
         * 设置一个cookie对象
         * new一个
         * 用json格式返回
         */
        if (\Yii::$app->user->isGuest) {
            (new ShopCart())->del($id)->save();
        }else{
            $userId = \Yii::$app->user->id;
            $cart = Cart::findOne(['goods_id'=>$id,'user_id'=>$userId]);
            $cart->delete();
     }

        $result = [
          'status'=>1,
            'msg'=>'删除成功',
        ];
        return Json::encode($result);
    }
}