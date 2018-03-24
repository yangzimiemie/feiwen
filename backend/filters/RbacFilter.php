<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/3/23
 * Time: 19:51
 */

namespace backend\filters;


use yii\base\ActionFilter;

class RbacFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        //判断当前用户有没有权限
        if(!\yii::$app->user->can($action->uniqueId)){
            $html = <<<html
        <script>
        window.history.go(-1);
        </script>
html;
            \yii::$app->session->setFlash('success','你没有权限操作');
            echo $html;
            return false;
        }
        return parent::beforeAction($action);
    }
}