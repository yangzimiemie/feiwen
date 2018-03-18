<?php

namespace backend\controllers;

use app\models\ArticleCategory;
use app\models\ArticleContent;
use backend\models\Article;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\captcha\CaptchaAction;

class ArticleController extends \yii\web\Controller
{
    /**
     * 文章列表显示
     * @return string
     */
    public function actionIndex()
    {
        $query = Article::find()->orderBy('id desc');
        //获取数据的条数
        $count = $query->count();
        //创建一个分页的对象
        $pages = new Pagination(['pageSize' => 3,'totalCount' => $count]);//每页的显示条数和总共的条数
        //查数据
        $article = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',compact('article','pages'));
    }

    /**
     * 添加方法
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //先创建一个数据模型对象
        $article = new Article();
        //创建文章内容对象
        $content = new ArticleContent();
        //获取文章分类的数据
        $cates = ArticleCategory::find()->all();
        //再把二维的转换为一维
        $catesArr=ArrayHelper::map($cates,'id','name');
        //request对象
        $request = \yii::$app->request;
        //判断是否是post提交
        if($request->isPost) {
            //绑定文章数据
            $article->load($request->post());
            //后台验证
            if($article->validate()){
                //保存文章数据
                if ($article->save(false)) {
                    //再去绑定文章内容的数据
                    $content->load($request->post());
                    //再去后台验证
                    if ($content->validate()) {
                        //给文章ID赋值
                        $content->article_id=$article->id;
                        //保存文章内容
                        if ($content->save()) {
                            //提示
                            \yii::$app->session->setFlash('success','添加成功啦！');
                            //返回列表
                            return $this->redirect('index');
                        }
                    }else{
                        var_dump($content->errors);exit;
                    }
                }
            }else{
                \yii::$app->session->setFlash('name','添加成功啦');
            }
        }
        //显示视图
        return $this->render('add',compact('article','catesArr','content'));
    }

    /**
     * 修改方法
     * @param $id  编辑的id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        //先创建一个数据模型对象
        $article =Article::findOne($id);
        //创建文章内容对象
        $content = new ArticleContent();
        //获取文章分类的数据
        $cates = ArticleCategory::find()->all();
        //再把二维的转换为一维
        $oneArr=ArrayHelper::map($cates,'id','name');
        //request对象
        $request = \yii::$app->request;
        //判断是否是post提交
        if($request->isPost){
            //绑定数据
            $article->load($request->post());
               //保存数据
                if ($article->save(false)) {
                    //绑定文章内容的
                    $content->load($request->post());
                    //验证
                    if ($content->validate()) {
                        //文章id赋值给cates
                        $content->article_id = $article->name;
                        //再去保存文章内容的数据
                        if ($content->save()) {
                            //提示添加
                            \yii::$app->session->setFlash('success', '添加成功');
                            //返回列表
                            return $this->redirect('index');
                        }
                    }else{
                        //错误信息
                        \yii::$app->session->setFlash('name','存在');
                    }
                    //提示添加成功
                    \yii::$app->session->setFlash('success','添加数据成功啦~');
                    //返回到列表
                    return $this->redirect('index');
                }
        }
        //显示视图
        return $this->render('edit',compact('article','oneArr','content'));
    }

    /**
     * 时间注入行为
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }

    /**
     * 验证码和富文本框
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
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => \Yii::getAlias("@web"),
            ],
        ],
        ];
    }
}
