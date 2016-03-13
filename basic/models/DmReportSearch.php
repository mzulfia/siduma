<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmReport;

/**
 * ReportSearch represents the model behind the search form about `app\models\Report`.
 */
class DmReportSearch extends DmReport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_report_id'], 'integer'],
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
        $query = DmReport::find();

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

        if (isset($_GET['DmReportSearch']) && !($this->load($params) && $this->validate())) {
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
          $query->andFilterWhere(['between', 'created_at', explode(" - ", $this->created_at)[0], date('Y-m-d', strtotime(explode(" - ", $this->created_at)[1] . ' +1 day'))]);
        
        return $dataProvider;
    }

    public function searchDmReports($params)
    {
        $query = DmReport::find();

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

        if (isset($_GET['DmReportSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['service', 'support']);

        $query->andFilterWhere([
            'status' => $this->status,
            'information' => $this->information,
            'dm_report.support_id' => $this->support_id
        ]);
        
        $query->andFilterWhere(['like', 'service_family.service_family_id', $this->service_family_id]);
       

        if(sizeof(explode(" - ", $this->created_at)) > 1)
          $query->andFilterWhere(['between', 'created_at', explode(" - ", $this->created_at)[0], date('Y-m-d', strtotime(explode(" - ", $this->created_at)[1] . ' +1 day'))]);
        
        return $dataProvider;
    }
}
