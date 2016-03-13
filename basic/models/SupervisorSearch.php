<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supervisor;

/**
 * SupervisorSearch represents the model behind the search form about `app\models\Supervisor`.
 */
class SupervisorSearch extends Supervisor
{
    public $supervisor_username;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supervisor_id', 'user_id'], 'integer'],
            [['spv_name', 'position', 'no_hp', 'email', 'image_path', 'supervisor_username'], 'safe'],
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
        $query = Supervisor::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['supervisor_username'] = [
              'asc' => ['user.username' => SORT_ASC],
              'desc' => ['user.username' => SORT_DESC],
        ];

        if (isset($_GET['SupervisorSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['user']);

        $query->andFilterWhere([
            'supervisor_id' => $this->supervisor_id,
            'position' => $this->position,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'spv_name', $this->spv_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'user.username', $this->supervisor_username]);
        
        return $dataProvider;
    }
}
