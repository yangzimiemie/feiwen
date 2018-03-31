<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/19
 * Time: 16:32
 */

namespace backend\controllers;

use backend\filters\RbacFilter;
use yii\captcha\CaptchaAction;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\Controller;

class CommenController extends Controller
{


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
                    "imageUrlPrefix"  => "http://admin.feiwen.com",//图片访问路径前缀
                ],
            ],
        ];
    }

    /**
     * 上传图片用的是webUpload
     * @return string
     */
    public function actionUpload(){
        //选择上传方式
        switch (\yii::$app->params['uploadType']){
            case "local":
                echo "local";
                break;
            case "qiniu":
                echo "qiniu";
                break;
        }
        $files = UploadedFile::getInstanceByName("file");
//       var_dump($files);exit;
        //判断
        if($files !== null){
            //路径
            $imgPath= "images".".".time().$files->extension;
            //移动并且阻止删除临时文件
            if($files->saveAs($imgPath,false)){
                //正确时
                $correct = [
                    'code'=>0,
                    'url'=>$imgPath,
                    'attachment'=>$imgPath,
                ];
                return json_encode($correct);
            }
        }else{
            $rst = [
                'code'=>1,
                'msg'=>'error'
            ];
            //JSON格式
            return json_encode($rst);
        }
    }

    /**
     * 用七牛的方式上传图片
     * @return string
     */
    public function actionQiniu()
    {
        $ak = 'g55WlYZmAcfjlQDw4CgilVkj-JiDkt6I7RtcPQM9';//应用ID
        $sk = '2XVES6fEUq2aK14htnOjSVf-7cOFd-2RHfknBjcy';//秘钥
        $domain = 'http://p5obj1i27.bkt.clouddn.com';//地址
        $bucket = 'php1108';//名称
        $zone = 'south_china';//华南区
        $qiniu = new Qiniu($ak, $sk, $domain, $bucket, $zone);
        $key = time();
        $key .= strtolower(strrchr($_FILES['file']['name'], '.'));//strrchr：返回从这个名字.后面的所有字符
        $qiniu->uploadFile($_FILES['file']['tmp_name'], $key);
        $url = $qiniu->getLink($key);
        $correct = [
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url,
        ];
        return json_encode($correct);
    }

}