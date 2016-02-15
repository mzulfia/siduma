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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['management_id', 'mgt_nip', 'user_id'], 'integer'],
            [['mgt_name', 'mgt_position'], 'safe'],
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'management_id' => $this->management_id,
            'mgt_nip' => $this->mgt_nip,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'mgt_name', $this->mgt_name])
            ->andFilterWhere(['like', 'mgt_position', $this->mgt_position]);

        return $dataProvider;
    }
}
