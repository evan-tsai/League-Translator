<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Items;

/**
 * ItemSearch represents the model behind the search form about `common\models\Items`.
 */
class ItemSearch extends Items
{
    public $item_type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id'], 'integer'],
            [['english', 'taiwan', 'china', 'korea', 'japan', 'item_type'], 'safe'],
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
        $query = Items::find();

        $query->joinWith('itemType');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'item_id' => $this->item_id,
        ]);

        $query->andFilterWhere(['like', 'english', $this->english])
            ->andFilterWhere(['like', 'taiwan', $this->taiwan])
            ->andFilterWhere(['like', 'china', $this->china])
            ->andFilterWhere(['like', 'korea', $this->korea])
            ->andFilterWhere(['like', 'japan', $this->japan])
            ->andFilterWhere(['in', 'item_type.subtype_id', $this->item_type]);

        return $dataProvider;
    }
}