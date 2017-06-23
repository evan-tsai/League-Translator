<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Champions;

/**
 * ChampionSearch represents the model behind the search form about `common\models\Champions`.
 */
class ChampionSearch extends Champions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'champion_id'], 'integer'],
            [['english', 'english_title', 'taiwan', 'taiwan_title', 'china', 'china_title', 'korea', 'korea_title', 'japan', 'japan_title'], 'safe'],
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
        $query = Champions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['english' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'champion_id' => $this->champion_id,
        ]);

        $query->andFilterWhere(['like', 'english', $this->english])
            ->andFilterWhere(['like', 'english_title', $this->english_title])
            ->andFilterWhere(['like', 'taiwan', $this->taiwan])
            ->andFilterWhere(['like', 'taiwan_title', $this->taiwan_title])
            ->andFilterWhere(['like', 'china', $this->china])
            ->andFilterWhere(['like', 'china_title', $this->china_title])
            ->andFilterWhere(['like', 'korea', $this->korea])
            ->andFilterWhere(['like', 'korea_title', $this->korea_title])
            ->andFilterWhere(['like', 'japan', $this->japan])
            ->andFilterWhere(['like', 'japan_title', $this->japan_title]);

        return $dataProvider;
    }
}