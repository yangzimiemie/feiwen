<?php

namespace backend\controllers;

use app\models\Brand;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Brand::find()->orderBy('id desc');
//        var_dump($brand);exit;
        //数据的总条数
        $count = $query->count();
        //创建一个分页的对象
        $pages = new Pagination(['pageSize' => 3,'totalCount' => $count]);//每页的显示条数和总共的条数
        //查数据
        $brand = $query->offset($pages->offset)->limit($pages->limit)->all();
        //视图
        return $this->render('index',compact('brand','pages'));
    }

    /**
     * 添加的功能
     * @return string|\yii\web\Response
     */
   public function actionAdd(){
        $brand = new Brand();
        $request = new Request();
        //判断post提交
       if($request->isPost){
           //getInstance保证一个类只有一个实列
           $brand->img = UploadedFile::getInstance($brand,'img');
            //定义一个空的图片路径
           $imgPath = "";
           //判断图片是否为空
           if ($brand->img!==null) {
               //保存图片的路径->extension：指的是规则里面的后缀
               $imgPath="images/".time().".".$brand->img->extension;
               //在去移动临时文件,false是因为默认有个删除临时文件
               $brand->img->saveAs($imgPath,false);
           }
           //绑定数据
           $brand->load($request->post());
           //判断
           if ($brand->validate()) {
               $brand->logo=$imgPath;
               //保存数据
               if ($brand->save(false)) {
                   //添加成功的提示
                   \yii::$app->session->setFlash('success','添加成功');
                   return $this->redirect('index');
               }
           }else{
                  var_dump($brand->errors);exit;
           }

       }
       //显示视图
       return $this->render('add',compact('brand'));
   }

    /**
     * 修改的功能
     * @param $id 修改传的id
     * @return string|\yii\web\Response
     */
   public function actionEdit($id){
       //找到一个id
       $brand = Brand::findOne($id);
       //判断post提交
       if(\yii::$app->request->isPost){
           //获得实列
           $brand->img=UploadedFile::getInstance($brand,'img');
           //先定义一个空的路径
           $imgPath = "";
           //判断图片是否为空
           if($brand->img!==null){
               //图片存的地方和格式
               $imgPath="images/".time().".".$brand->img->extension;
               //移动临时文件并且要阻止删除默认临时文件
               $brand->img->saveAs($imgPath,false);
           }
           //绑定数据
           $brand->load(\yii::$app->request->post());
           //验证
           if ($brand->validate()) {
               //在保存数据前传到视图的logo中去
               $brand->logo=$imgPath;//一定要传到视图中的logo中去不然不可以修改
               //保存数据
               if ($brand->save()) {
                   //修改成功的提示
                   \yii::$app->session->setFlash('success','修改成功啦~');
                   //返回列表
                   return $this->redirect('index');
               }
           }
       }
       //现实视图
       return $this->render('edit',compact('brand'));
   }

    /**
     * 删除功能
     * @param $id 删除id
     * @return \yii\web\Response
     */
   public function actionDel($id){
       if ($brand = Brand::findOne($id)->delete()) {
//           return $this->redirect('index');
//       }
       if ($brand){
           if($brand->delete()){
               echo 1; Yii::$app->end();
           }
       }
            echo 0; Yii::$app->end();
       }
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
}
