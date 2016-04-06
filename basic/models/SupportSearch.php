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
    public $support_username;

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
            [['support_id', 'user_id'], 'integer'],
            [['support_name', 'no_hp', 'company', 'email', 'support_username', 'support_position_id'], 'safe'],
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

        $dataProvider->sort->attributes['support_username'] = [
              'asc' => ['user.username' => SORT_ASC],
              'desc' => ['user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_position_id'] = [
              'asc' => ['support_position.position_name' => SORT_ASC],
              'desc' => ['support_position.position_name' => SORT_DESC],
        ];


        if (isset($_GET['SupportSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['user', 'pos']);

        $query->andFilterWhere([
            'support_id' => $this->support_id,
            'user_id' => $this->user_id,
            'support_position.support_position_id' => $this->support_position_id
        ]);

        $query->andFilterWhere(['like', 'support_name', $this->support_name])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'user.username', $this->support_username]);
        
        return $dataProvider;
    }
}
