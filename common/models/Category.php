<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $sort
 * @property integer $created_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    Ad::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pid'], 'required'],
            [['id', 'pid', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名字',
            'pid' => '父ID',
            'sort' => '排序',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @title 列表用到
     */
    public static function getAll()
    {
        $cate = static::find()->asArray()->all();
        return recursion($cate, $pid=0, $type=2);
    }

    /**
     * @title 创建菜单时选择父级
     */
    public static function getPids($have_top = true)
    {
        $sel = static::find()->select(['id', 'pid', 'name'])
                              ->asArray()
                              ->all();
        $sel = recursion($sel, $pid=0, $type=2);
        $arr = [];
        if ($have_top) {
            $arr = ['0'=>'顶级'];
        }
        foreach ($sel as $v) {
            $arr[$v['id']] = $v['html'] . $v['name'];
        }
        return $arr;
    }
}
