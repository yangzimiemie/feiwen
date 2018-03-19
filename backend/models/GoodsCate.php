<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use Yii;

/**
 * This is the model class for table "goods_cate".
 *
 * @property int $id
 * @property string $name 商品分类名
 * @property int $parent_id 商品父级ID
 * @property int $tree 树
 * @property string $lft 左值
 * @property string $rgt 右值
 * @property string $detail 简介
 */
class GoodsCate extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['detail'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品分类名',
            'parent_id' => '商品父级ID',
            'tree' => '树',
            'lft' => '左值',
            'rgt' => '右值',
            'detail' => '简介',
            'depth'=>'深度'

        ];
    }
    /**
     * 注入行为
     * @return array
     */
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    //得到层级结构
    public function getNameText(){
    return str_repeat("┈",$this->depth*4).$this->name;
    }
}
