<?php

namespace backend\controllers;

use backend\models\Caidan;

class CaidanController extends \yii\web\Controller
{
    /**
     * 菜单列表
     * @return string
     */
    public function actionIndex()
    {
        $model = Caidan::find()->all();
        return $this->render('index',compact('model'));
    }

    /**
     * 添加菜单
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        $model = new Caidan();
        if ($model->load(\yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \yii::$app->session->setFlash('success','添加成功');
                return $this->refresh();
            }
        }
       return $this->render('add',compact('model'));
    }
}
