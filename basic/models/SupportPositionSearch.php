<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupportPosition;

/**
 * SupportPositionSearch represents the model behind the search form about `app\models\SupportPosition`.
 */
class SupportPositionSearch extends SupportPosition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_position_id'], 'integer'],
            [['position_name'], 'safe'],
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
        $query = SupportPosition::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'support_position_id' => $this->support_position_id,
        ]);

        $query->andFilterWhere(['like', 'position_name', $this->position_name]);

        return $dataProvider;
    }
}
