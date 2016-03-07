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
            [['support_id', 'support_position_id', 'user_id'], 'integer'],
            [['support_name', 'no_hp', 'company', 'email'], 'safe'],
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

        if (isset($_GET['ReportSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }
        $query->andFilterWhere([
            'support_id' => $this->support_id,
            'support_position_id' => $this->support_position_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'support_name', $this->support_name])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp]);

        return $dataProvider;
    }
}
