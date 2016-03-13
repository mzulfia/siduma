<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupportReport;

/**
 * SupportReportSearch represents the model behind the search form about `app\models\SupportReport`.
 */
class SupportReportSearch extends SupportReport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_family_id'], 'integer'],
            [['information', 'created_at', 'support_id', 'service_family_id'], 'safe'],
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
        $query = SupportReport::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
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

        if (isset($_GET['SupportReportSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['service', 'support']);

        $query->andFilterWhere([
            'information' => $this->information
        ]);
        
        $query->andFilterWhere(['like', 'service_family.service_family_id', $this->service_family_id]);
        $query->andFilterWhere(['like', 'support.support_name', $this->support_id]);

        if(sizeof(explode(" - ", $this->created_at)) > 1)
          $query->andFilterWhere(['between', 'created_at', explode(" - ", $this->created_at)[0], date('Y-m-d', strtotime(explode(" - ", $this->created_at)[1] . ' +1 day'))]);
        
        return $dataProvider;
    }

    public function searchSupportReports($params)
    {
        $query = SupportReport::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
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

        if (isset($_GET['SupportReportSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['service', 'support']);

        $query->andFilterWhere([
            'information' => $this->information,
            'support_report.support_id' => $this->support_id
        ]);
        
        $query->andFilterWhere(['like', 'service_family.service_family_id', $this->service_family_id]);
       

        if(sizeof(explode(" - ", $this->created_at)) > 1)
          $query->andFilterWhere(['between', 'created_at', explode(" - ", $this->created_at)[0], date('Y-m-d', strtotime(explode(" - ", $this->created_at)[1] . ' +1 day'))]);
        
        return $dataProvider;
    }
}
