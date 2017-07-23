<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MasterySearch represents the model behind the search form about `common\models\Masteries`.
 */
class MasterySearch extends Masteries
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mastery_id', 'type'], 'integer'],
            [['english', 'taiwan', 'china', 'korea', 'japan'], 'safe'],
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
        $query = Masteries::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['type' => SORT_ASC]],
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
            'type' => $this->type,
            'mastery_id' => $this->mastery_id,
        ]);

        $query->andFilterWhere(['like', 'english', $this->english])
            ->andFilterWhere(['like', 'taiwan', $this->taiwan])
            ->andFilterWhere(['like', 'china', $this->china])
            ->andFilterWhere(['like', 'korea', $this->korea])
            ->andFilterWhere(['like', 'japan', $this->japan]);

        return $dataProvider;
    }
}