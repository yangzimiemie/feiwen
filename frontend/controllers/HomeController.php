<?php

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCate;

class HomeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionList($id){
        //先得到一个当前对象
        $list = GoodsCate::findOne($id);
        //通过当前对象去把所有的子分类找出来
        $cates = GoodsCate::find()->where(['tree'=>$list->tree])->andWhere(['>=','lft',$list->lft])->andWhere(['<=','rgt',$list->rgt])->asArray()->all();
       //转为一维
        $cate = array_column($cates,'id');
        //得到所有的商品
        $goods = Goods::find()->where(['in','goods_cate_id',$cate])->all();
        return $this->render('list',compact('goods'));
    }
}
