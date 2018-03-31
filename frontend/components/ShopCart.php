<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/31
 * Time: 11:13
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
   private $cart;

   public function __construct(array $config = [])
   {
       $getCookie = \Yii::$app->request->cookies;
//            var_dump($getCookie);exit;
       //获得原来购物车的数据
       $this->cart = $getCookie->getValue('cart',[]);
       parent::__construct($config);
   }

//   添加
     public function add($id,$num){

         if(array_key_exists($id,$this->cart)){
             $this->cart[$id]+=$num;
         }else{
             $this->cart[$id]=(int)$num;//因为是字符串转为int类型
         }
         return $this;
     }
     //保存
    public function save(){
        //先设置cookie对象
        $setCookie = \Yii::$app->response->cookies; //设置是response 得到是request
        //new一个cookie对象
        $cookie = new Cookie([
            'name'=>'cart',
            'value' => $this->cart,
            'expire' => time()+3600*24*30*12,//设置cookie过期时间
        ]);
        //通过设置的cookie对象来添加一个cookie对象
        $setCookie->add($cookie);
        return $this;
    }
    //修改
    public function update($id,$num){
        if($this->cart[$id]) {
            $this->cart[$id] = $num;
        }
          return $this;
    }
    //删除
    public function del($id){
        if($this->cart[$id]){
            unset($this->cart[$id]);
        }
        return $this;
    }
    //查看
    public function get(){
       return  $this->cart;
    }

    //清空cookie
    public function flush(){
        $this->cart=[];
        return $this;
    }

    //同步数据库操作
    public function synDb(){
        $userId=\Yii::$app->user->id;
        foreach ($this->cart as $goodId=>$num){
            //判断当前用户当前商品有没有存在
            $cartDb=Cart::findOne(['goods_id'=>$goodId,'user_id'=>$userId]);
            //判断
            if ($cartDb){
                //+ 修改操作
                $cartDb->num+=$num;
                // $cart->save();
            }else{
                //创建对象
                $cartDb=new Cart();
                //赋值
                $cartDb->goods_id=$goodId;
                $cartDb->num=$num;
                $cartDb->user_id=$userId;
            }
            //保存
            $cartDb->save();
        }
        return $this;
    }

}