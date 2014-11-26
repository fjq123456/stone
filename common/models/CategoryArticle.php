<?php

namespace common\models;

use common\models\Category;
/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $sort
 * @property integer $created_at
 */
// class GoodsCategory extends \yii\db\ActiveRecord
class CategoryArticle extends Category
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{article_category}}';
    }
}
