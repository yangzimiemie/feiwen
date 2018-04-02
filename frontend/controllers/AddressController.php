<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;

class AddressController extends \yii\web\Controller
{
    /**
     * 解决400 CSRF
     */
    public function init(){
        $this->enableCsrfValidation = false;
    }
    public function actionIndex()
    {
        $address = Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        return $this->render('index',compact('address'));
    }
    /**
     * 添加收货地址
     * @return string
     */
    public function actionAdd(){
      $request = \Yii::$app->request;
        if ($request->isPost) {
            $address = new Address();
            $address->load($request->post());
            if ($address->validate()) {
                $address->user_id=\Yii::$app->user->id;
//                var_dump($address->status);exit;
                if ($address->status===null) {
                    $address->status=0;
                }else{
                    Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);
                    $address->status=1;
                }
                if ($address->save()) {
                    $result = ['status'=>1,'msg'=>'添加地址成功~'];
                    return Json::encode($result);
                }
            }else{
                $result = ['status'=>0,'msg'=>'添加地址失败~'];
                return Json::encode($result);
            }
        }
//         return $this->render('index',compact('address'));
    }
    public function actionDel($id){
        if (Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete()) {
            $result = [
                 'status'=>1,
                 'msg'=>'删除成功'
            ];
            return Json::encode($result);
        }
    }
}
