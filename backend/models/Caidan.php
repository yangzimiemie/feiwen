<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "caidan".
 *
 * @property int $id id
 * @property string $name 名称
 * @property string $icon 图标
 * @property string $url 访问地址
 * @property int $parent_id 父级ID
 */
class Caidan extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['name','url','parent_id'],'required'],
            [['icon'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => '名称',
            'icon' => '图标',
            'url' => '访问地址',
            'parent_id' => '父级ID',
        ];
    }
//声明一个静态方法
public static function menus(){
    $menuAll=[
                'label' => '商品模块', 'icon' => 'cart-arrow-down', 'url' => ['index'],
                'items' => [
                ['label' => '商品管理', 'icon' => 'paint-brush', 'url' => ['goods/index'],],
                ['label' => '商品分类', 'icon' => 'folder-open', 'url' => ['goods-cate/index'],],
                ],
                ];
    $menuAll=[];
    //得到所有父级
    $menuPar = self::find()->where(['parent_id'=>0])->all();
    //循环出来
    foreach ($menuPar as $menuAll){
      $newMenu=[];
      $newMenu['label']=$menuAll->name;
      $newMenu['icon']=$menuAll->icon;
      $newMenu['url']=$menuAll->url;
       //再去找父级ID的娃儿
        $parChind = self::find()->where(['parent_id'=>$menuAll->id])->all();
        //再去循环
        foreach ($parChind as $chind){
            $newChind = [];
            $newChind['label']=$chind->name;
            $newChind['icon']=$chind->icon;
            $newChind['url']=$chind->url;
            $newMenu['items'][]=$newChind;
        }
        $menuAll=$newMenu;
    }
//    exit;
    return $menuAll;
}
}
