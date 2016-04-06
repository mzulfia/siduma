<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Management;

/**
 * ManagementSearch represents the model behind the search form about `app\models\Management`.
 */
class ManagementSearch extends Management
{
    
    public $management_username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['management_id'], 'integer'],
            [['mgt_name', 'position', 'no_hp', 'email', 'image_path', 'management_username'], 'safe'],
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
        $query = Management::find();
          
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['management_username'] = [
              'asc' => ['user.username' => SORT_ASC],
              'desc' => ['user.username' => SORT_DESC],
        ];

        if (isset($_GET['ManagementSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['user']);

        $query->andFilterWhere([
            'management_id' => $this->management_id,
            'position' => $this->position,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'mgt_name', $this->mgt_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'user.username', $this->management_username]);
        
        return $dataProvider;
    }
}
