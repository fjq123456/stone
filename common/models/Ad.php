<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property string $intro
 * @property integer $img
 * @property integer $res_name
 * @property integer $status
 * @property integer $created_at
 */
class Ad extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{ad}}';
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
            ['title', 'required', 'message'=>'标题不可为空'],
            ['link', 'required', 'message'=>'指向链接不可为空'],
            ['res_name', 'required', 'message'=>'类型名不可为空'],
            [['intro'], 'string'],
            [['img', 'status', 'created_at'], 'integer'],
            [['title', 'link', 'res_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'link' => '连接',
            'intro' => '简介',
            'img' => '上传图片',
            'res_name' => '资源分类名',
            'status' => '状态',
            'created_at' => '创建',
        ];
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => '正常',
            self::STATUS_DELETE => '删除'
        ];
    }

    public function getStatusText()
    {
        $s = $this->getStatusList();
        return $s[$this->status];
    }
}
