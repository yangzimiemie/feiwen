<?php

namespace backend\controllers;
use yii\captcha\CaptchaAction;
use app\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Request;

class ArticleCateController extends \yii\web\Controller
{
    /**
     * 显示列表方法
     * @return string
     */
    public function actionIndex()
    {
        $query = ArticleCategory::find()->orderBy('sort desc');
        //获取数据的条数
        $count = $query->count();
        //创建一个分页的对象
        $pages = new Pagination(['pageSize' => 3,'totalCount' => $count]);//每页的显示条数和总共的条数
        //查数据
        $cate = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',compact('cate','pages'));
    }

    /**
     * 添加方法
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //先new一个数据模型对象
        $cate = new ArticleCategory();
        //判断是否post提交
        if(\yii::$app->request->isPost){
            //绑定数据
            $cate->load(\yii::$app->request->post());
            //后台验证
            if ($cate->validate()) {
                //保存数据
                if ($cate->save(false)) {
                    //提示添加成功
                    \yii::$app->session->setFlash('success','添加成功啦~');
                    return $this->redirect('index');
                }
            }else{
                //打印错误信息
                \yii::$app->session->setFlash('name','已重名');
            }
        }
        return $this->render('add',compact('cate'));
    }

    /**
     * 验证码
     * @return array
     */
    public function actions()
    {
        return [
            'code'=>[
                'class'=>CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme':null,
                'maxLength' => 3,
                'minLength' => 3,
            ],
        ];
    }

    /**
     * 修改的方法
     * @param $id 修改的id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        //找到一个id
        $cate = ArticleCategory::findOne($id);
        //request对象
        $request = new Request();
        //判断是否post提交
        if ($request->isPost) {
            //绑定数据
            $cate->load($request->post());
            //后台验证
            if ($cate->validate()) {
                //保存数据
                if ($cate->save(false)) {
                    //提示
                    \yii::$app->session->setFlash('success','修改成功啦~');
                    //显示列表
                    return $this->redirect('index');
                }
            }else{
                //打印错误信息
                \yii::$app->session->setFlash('name','已存在');
            }
        }
        //显示视图
      return  $this->render('edit',compact('cate'));
    }

    /**
     * 删除方法
     * @param $id 删除传的id
     * @return \yii\web\Response
     */
    public function actionDel($id){
        if ($cate = ArticleCategory::findOne($id)->delete()) {
            return $this->redirect('index');
        }
    }
}
