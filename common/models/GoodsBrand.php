<?php

namespace common\models;

use Yii;
use common\models\CategoryGoods;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "goods_brand".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name_cn
 * @property string $name_en
 * @property string $logo
 * @property string $intro
 * @property string $url
 * @property string $story
 * @property integer $status
 * @property integer $create_at
 */
class GoodsBrand extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{goods_brand}}';
    }

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
            [['category_id', 'name_cn'], 'required'],
            [['id', 'category_id', 'status'], 'integer'],
            [['intro', 'story'], 'string'],
            [['name_cn', 'name_en'], 'string', 'max' => 100],
            [['logo', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类ID',
            'name_cn' => '中文名',
            'name_en' => '英文名',
            'logo' => 'Logo标志',
            'intro' => '介绍',
            'url' => '官网地址',
            'story' => '品牌故事',
            'status' => '状态',
            'created_at' => '添加时间',
            'categorystr' => '品牌分类',
            'statustext' => '状态'
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(CategoryGoods::className(), ['id' => 'category_id']);
    }

    public function getCategoryStr()
    {
        $cate = $this->category;
        return $cate->name;
    }

    public function getStatusText()
    {
        $arr = $this->getStatusArr();
        return $arr[$this->status];
    }

    public function getStatusArr()
    {
        return [
            self::STATUS_DELETE => '删除', 
            self::STATUS_ACTIVE => '正常',
        ];
    }
}
