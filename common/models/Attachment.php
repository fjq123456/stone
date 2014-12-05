<?php

namespace common\models;

use Yii;
use common\helpers\Upload;
/**
 * This is the model class for table "attachment".
 *
 * @property integer $id
 * @property string $title
 * @property string $path
 * @property string $name
 * @property integer $res_id
 * @property string $res_name
 * @property string $md5
 * @property integer $sort
 * @property string $created_at
 * @property string $ext
 * @property integer $status
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['path', 'name', 'res_name', 'md5', 'ext'], 'required'],
//            [['res_id', 'sort', 'status'], 'integer'],
//            [['created_at'], 'safe'],
//            [['title', 'path'], 'string', 'max' => 255],
//            [['name'], 'string', 'max' => 64],
//            [['res_name'], 'string', 'max' => 100],
//            [['md5'], 'string', 'max' => 32],
//            [['ext'], 'string', 'max' => 10]
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
            'path' => Yii::t('app', 'Path'),
            'name' => Yii::t('app', 'Name'),
            'res_id' => Yii::t('app', 'Res ID'),
            'res_name' => Yii::t('app', 'Res Name'),
            'md5' => Yii::t('app', 'Md5'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'ext' => Yii::t('app', 'Ext'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function setResName($res_name)
    {
        $this->res_name = $res_name;
    }

    public function setResId($res_id)
    {
        $this->res_id = $res_id;
    }

    public function setInfo(Upload $upload, $res_name)
    {
        $savePath = Yii::$app->params['savePath'];

        $filename = $upload->save($res_name);
        $content = file_get_contents($filename);
        if (empty($content)) return false;

//        Upload::thumb($filename, $res_name); //缩略图

        $filename = ltrim($filename, '/');
        $file = basename($filename);
        $data = [
            'path' => str_replace($savePath, '', dirname($filename)),
            'ext'  => substr($file, strrpos($file, '.')+1),
            'name'=> substr($file, 0, strrpos($file, '.')),
            'res_name' => $res_name,
            'md5'  => md5($content)
        ];
        $this->setAttributes($data, false);
        return $this;
    }

    public static function getUrl($id, $type='')
    {
        !empty($type) && $type = $type.'_';
        $info = self::findOne($id);
        $savePath = Yii::$app->params['savePath'];
        return $savePath . $info['path'] . '/' . $type . $info['name'] . '.' . $info['ext'];
    }
}
