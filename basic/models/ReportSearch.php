<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Report;

/**
 * ReportSearch represents the model behind the search form about `app\models\Report`.
 */
class ReportSearch extends Report
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id'], 'integer'],
            [['information', 'created_at', 'status', 'support_id', 'service_family_id'], 'safe'],
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
        $query = Report::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['service_family_id'] = [
              'asc' => ['service_family.service_name' => SORT_ASC],
              'desc' => ['service_family.service_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['service_family_id'] = [
              'asc' => ['service_family.service_name' => SORT_ASC],
              'desc' => ['service_family.service_name' => SORT_DESC],
        ];

         $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.support_name' => SORT_ASC],
              'desc' => ['support.support_name' => SORT_DESC],
        ];

        if (isset($_GET['ReportSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['service', 'support']);

        $query->andFilterWhere([
            'status' => $this->status,
            'information' => $this->information
        ]);
        
        $query->andFilterWhere(['like', 'service_family.service_family_id', $this->service_family_id]);
        $query->andFilterWhere(['like', 'support.support_name', $this->support_id]);

        if(sizeof(explode(" - ", $this->created_at)) > 1)
          $query->andFilterWhere(['between', 'created_at', explode(" - ", $this->created_at)[0], explode(" - ", $this->created_at)[1]]);
        
        return $dataProvider;
    }
}
