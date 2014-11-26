<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsBrand;

/**
 * SearchBrand represents the model behind the search form about `common\models\GoodsBrand`.
 */
class SearchBrand extends GoodsBrand
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cate_id', 'status', 'created_at'], 'integer'],
            [['name_cn', 'name_en', 'logo', 'intro', 'url', 'story'], 'safe'],
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
        $query = GoodsBrand::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cate_id' => $this->cate_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name_cn', $this->name_cn])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'story', $this->story]);

        return $dataProvider;
    }
}
