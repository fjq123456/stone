<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\User;
use common\models\CategoryArticle;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $category_id
 * @property integer $user_id
 * @property integer $ip
 * @property integer $view_all
 * @property integer $recommend
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \yii\db\ActiveRecord
{

    const STATUS_DRAFT = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{article}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['category_id', 'user_id', 'view_all', 'recommend', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title','ip'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'category_id' => Yii::t('app', 'Category ID'),
            'user_id' => Yii::t('app', 'Author'),
            'ip' => Yii::t('app', 'Ip'),
            'view_all' => Yii::t('app', 'View All'),
            'recommend' => Yii::t('app', 'Recommend'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'author' => Yii::t('app', 'Author'),
            'categoryname' => Yii::t('app', 'Category Name'),
        ];
    }

    public static function getStatus()
    {
        return [
            self::STATUS_DELETE => '删除',
            self::STATUS_ACTIVE => '发布',
            self::STATUS_DRAFT  => '草稿'
        ];
    }

    public function getStatusText()
    {
        $sta = self::getStatus();
        return $sta[$this->status];
    }

    public function getAuthor()
    {
        return User::getNameById($this->user_id);
    }


    public function getCategory()
    {
        return $this->hasOne(CategoryArticle::className(), ['id' => 'category_id']);
    }

    public function getCategoryName()
    {
        $cate = $this->category;
        return $cate->name;
    }

    public function beforeSave($insert=false)
    {
        if (parent::beforeSave($insert)) {
            $this->user_id = Yii::$app->user->id;
            $this->ip = Yii::$app->request->getUserIP();
            return true;
        }
    }

}
