<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Images;

/**
 * SearchImages represents the model behind the search form about `common\models\Images`.
 */
class SearchImages extends Images
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'res_id', 'sort', 'status'], 'integer'],
            [['title', 'intro', 'path', 'name', 'res_name', 'md5', 'created_at', 'ext'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Images::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'res_id' => $this->res_id,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'md5', $this->md5])
            ->andFilterWhere(['like', 'ext', $this->ext]);

        return $dataProvider;
    }
}
