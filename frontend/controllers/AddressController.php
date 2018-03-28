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
        $address = Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        $model = new Address();
        $request = \Yii::$app->request;
        if ($request->isPost) {
           $model->load($request->post());
            if ($model->validate()) {
                $model->user_id=\Yii::$app->user->id;
                if ($model->status===null) {
                    $model->status=0;
                }else{
                    Address::updateAll(['status'=>0,'user_id'=>$model->user_id]);
                    $model->status=1;
                }
                if ($model->save()) {
                    $result = ['status'=>1,'data'=>$model->errors,'msg'=>'添加地址成功~'];
                    return Json::encode($result);
                }
            }else{
                $result = ['status'=>0,'data'=>$model->errors,'msg'=>'添加地址失败~'];
                return Json::encode($result);
            }
        }
        return $this->render('index',compact('address'));
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
