<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Support;

/**
 * SupportSearch represents the model behind the search form about `app\models\Support`.
 */
class SupportSearch extends Support
{
     public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['support_position_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_id', 'no_hp', 'support_position_id', 'user_id'], 'integer'],
            [['support_name', 'company'], 'safe'],
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
        $query = Support::find();

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
            'support_id' => $this->support_id,
            'no_hp' => $this->no_hp,
            'support_position_id' => $this->support_position_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'support_name', $this->support_name])
            ->andFilterWhere(['like', 'company', $this->company]);

        return $dataProvider;
    }
}
