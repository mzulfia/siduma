<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Guest;

/**
 * GuestSearch represents the model behind the search form about `app\models\Guest`.
 */
class GuestSearch extends Guest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guest_id'], 'integer'],
            [['guest_nip', 'guest_name', 'importance', 'in_time', 'out_time'], 'safe'],
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
        $query = Guest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'guest_id' => $this->guest_id,
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
        ]);

        $query->andFilterWhere(['like', 'guest_nip', $this->guest_nip])
            ->andFilterWhere(['like', 'guest_name', $this->guest_name])
            ->andFilterWhere(['like', 'importance', $this->importance]);

        return $dataProvider;
    }
}
