<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/29
 * Time: 15:21
 */

namespace backend\controllers;


use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCate;
use backend\models\GoodsDetail;
use backend\models\GoodsImages;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class GoodsController extends CommenController
{

    /**
     * 商品列表
     * @return string
     */
    public function actionIndex()
    {

        $query = Goods::find()->orderBy('id desc');
        $minPrice = \yii::$app->request->get('minPrice');
        $maxPrice = \yii::$app->request->get('maxPrice');
        $keyword = \yii::$app->request->get('keyword');
        $status = \yii::$app->request->get('status');
        if($minPrice){
            $query->andWhere(['>=','price',$minPrice]);
        }
        if($maxPrice){
            $query->andWhere(['<=','price',$maxPrice]);
        }
        if($keyword !==""){
            $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
        }
        if ($status === "0" or $status==="1"){
            $query->andWhere(['status'=>$status]);
        }
        //获取数据的条数
        $count = $query->count();
        //创建一个分页的对象
        $pages = new Pagination(['pageSize' => 3, 'totalCount' => $count]);//每页的显示条数和总共的条数
        //查数据
        $goods = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', compact('goods', 'pages'));
    }

    /**
     * 添加方法
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {

        $goods = new Goods();
        $img = new GoodsImages();
        //找到id
        $conts = Goods::find()->count();
        $cates = GoodsCate::find()->orderBy('tree,lft')->all();
        //再把二维的转换为一维
        $catesArr = ArrayHelper::map($cates, 'id', 'nameText');
        $brands = Brand::find()->all();
        $brandArr = ArrayHelper::map($brands, 'id', 'name');
        $details = new GoodsDetail();
        $rst = new Request();
        if ($rst->isPost) {
            $goods->load($rst->post());
            $img->load($rst->post());
            if ($goods->validate()) {
                if (!$goods->sn) {
                    $goodsTime = strtotime(date('Ymd'));
                    $count = Goods::find()->where(['>', 'create_time', $goodsTime])->count();
                    $count = $count + 1;
                    $countStr = "0000" . $count;
                    $countStr = substr($countStr, -5);
                    $goods->sn = date('Ymd') . $countStr;
                }
                if ($goods->save()) {
                    $img->goods_id=$goods->id;
                    $img->save();
                    foreach ($goods->images as $image){
                        $files = new GoodsImages();
                        $files->goods_id=$goods->id;
                        $files->images=$image;
                        $files->save();
                    }
                    //绑定文章详情数据
                    $details->load($rst->post());
                    if ($details->validate()) {
                        $details->goods_id=$goods->id;
                        if ($details->save()) {

                            //提示
                            \yii::$app->session->setFlash('success', '添加成功啦！');
                            //返回列表
                            return $this->refresh();
                        }
                    } else {
                        var_dump($details->errors);
                        exit;
                    }
                }
            }else{
                \yii::$app->session->setFlash('name', '添加成功啦');
            }
        }
        //显示视图
        return $this->render('add', compact('goods', 'details', 'conts', 'catesArr', 'brandArr'));
    }

    /**
     * 修改
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $goods = Goods::findOne($id);
        $img = new GoodsImages();
        //找到id
        $conts = Goods::find()->count();
        $cates = GoodsCate::find()->orderBy('tree,lft')->all();
        //再把二维的转换为一维
        $catesArr = ArrayHelper::map($cates, 'id', 'nameText');
        $brands = Brand::find()->all();
        $brandArr = ArrayHelper::map($brands, 'id', 'name');
        $details = new GoodsDetail();
        $rst = new Request();
        if ($rst->isPost) {
            $goods->load($rst->post());
            $img->load($rst->post());
            if ($goods->validate()) {
                if (!$goods->sn) {
                    $goodsTime = strtotime(date('Ymd'));
                    $count = Goods::find()->where(['>', 'create_time', $goodsTime])->count();
                    $count = $count + 1;
                    $countStr = "0000" . $count;
                    $countStr = substr($countStr, -5);
                    $goods->sn = date('Ymd') . $countStr;
                }
                if ($goods->save()) {
                    GoodsImages::deleteAll(['goods_id'=>$id]);
                    foreach ($goods->images as $image){
                        $files = new GoodsImages();
                        $files->goods_id=$id;
                        $files->images=$image;
                        $files->save();
                    }
                    //绑定文章详情数据
                    $details->load($rst->post());
                    if ($details->validate()) {
                        $details->goods_id=$goods->id;
                        if ($details->save()) {
                            //提示
                            \yii::$app->session->setFlash('success', '添加成功啦！');
                            //返回列表
                            return $this->refresh();
                        }
                    } else {
                        var_dump($details->errors);
                        exit;
                    }
                }
            }else{
                \yii::$app->session->setFlash('name', '修改成功啦');
            }
        }
        $images = GoodsImages::find()->where(['goods_id'=>$id])->asArray()->all();
        $images = array_column($images,'images');
        $goods->images = $images;
//        var_dump($images);exit;
        //显示视图
        return $this->render('edit', compact('goods', 'details', 'conts', 'catesArr', 'brandArr'));
    }
    public function actionDel($id){
        if (Goods::findOne($id)->delete()) {
            return $this->redirect('index');
        }
    }
}