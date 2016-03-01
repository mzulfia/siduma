<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Schedule;

/**
 * ScheduleSearch represents the model behind the search form about `app\models\Schedule`.
 */
class ScheduleSearch extends Schedule
{
    public $shift_name;
    public $support_name;
    public $position_name;

    // public function attributes()
    // {
    //     // add related fields to searchable attributes
    //     return array_merge(parent::attributes(), ['support_id']);
    // }
    /**
     * @inheritdoc  
     */
    public function rules()
    {
        return [
            [['date', 'shift_id', 'is_dm', 'support_id', 'position_name'], 'safe'],
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
        $query = Schedule::find();

        $dataProvider = new ActiveDataProvider([    
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['shift_id'] = [
              'asc' => ['shift.shift_name' => SORT_ASC],
              'desc' => ['shift.shift_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['shift_id'] = [
              'asc' => ['shift.shift_start' => SORT_ASC],
              'desc' => ['shift.shift_start' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['shift_id'] = [
              'asc' => ['shift.shift_end' => SORT_ASC],
              'desc' => ['shift.shift_end' => SORT_DESC],
        ];

         $dataProvider->sort->attributes['position_name'] = [
              'asc' => ['support_position.position_name' => SORT_ASC],
              'desc' => ['support_position.position_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.support_name' => SORT_ASC],
              'desc' => ['support.support_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.email' => SORT_ASC],
              'desc' => ['support.email' => SORT_DESC],
        ];

         $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.no_hp' => SORT_ASC],
              'desc' => ['support.no_hp' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.company' => SORT_ASC],
              'desc' => ['support.company' => SORT_DESC],
        ];


        if (isset($_GET['ScheduleSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['shift', 'support', 'support.pos']);

        $query->andFilterWhere([
            'schedule_id' => $this->schedule_id,
            
            'is_dm' => $this->is_dm,
        ]);
        
        $query->andFilterWhere(['like', 'shift.shift_name', $this->shift_id]);
        $query->andFilterWhere(['like', 'support.support_name', $this->support_id]);
        $query->andFilterWhere(['like', 'support_position.position_name', $this->position_name]);

       if(sizeof(explode(" - ", $this->date)) > 1)
          $query->andFilterWhere(['between', 'date', explode(" - ", $this->date)[0], date('Y-m-d', strtotime(explode(" - ", $this->date)[1] . ' +1 day'))]);
        
        return $dataProvider;
    }

    public function searchDM($params)
    {
        $query = Schedule::find();

        $dataProvider = new ActiveDataProvider([    
            'query' => $query,
            'sort'=> ['defaultOrder' => ['shift_id'=>SORT_ASC]]
        ]);

         $dataProvider->sort->attributes['position_name'] = [
              'asc' => ['support_position.position_name' => SORT_ASC],
              'desc' => ['support_position.position_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.support_name' => SORT_ASC],
              'desc' => ['support.support_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.email' => SORT_ASC],
              'desc' => ['support.email' => SORT_DESC],
        ];

         $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.no_hp' => SORT_ASC],
              'desc' => ['support.no_hp' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.company' => SORT_ASC],
              'desc' => ['support.company' => SORT_DESC],
        ];


        if (isset($_GET['ScheduleSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['shift', 'support', 'support.pos']);

        $query->andFilterWhere([
            'schedule_id' => $this->schedule_id,
            // 'shift.shift_id' => $this->shift_id,
            'date' => $this->date,
            'is_dm' => $this->is_dm,
        ]);
        
        $query->andFilterWhere(['like', 'shift.shift_name', $this->shift_id]);
        $query->andFilterWhere(['like', 'support.support_name', $this->support_id]);
        $query->andFilterWhere(['like', 'support_position.position_name', $this->position_name]);
        
        return $dataProvider;
    }

    public function searchTeam($params)
    {
        $query = Schedule::find();

        $dataProvider = new ActiveDataProvider([    
            'query' => $query,
            'sort'=> ['defaultOrder' => ['is_dm'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['shift_id'] = [
              'asc' => ['shift.shift_name' => SORT_ASC],
              'desc' => ['shift.shift_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['shift_id'] = [
              'asc' => ['shift.shift_start' => SORT_ASC],
              'desc' => ['shift.shift_start' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['shift_id'] = [
              'asc' => ['shift.shift_end' => SORT_ASC],
              'desc' => ['shift.shift_end' => SORT_DESC],
        ];

         $dataProvider->sort->attributes['position_name'] = [
              'asc' => ['support_position.position_name' => SORT_ASC],
              'desc' => ['support_position.position_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.support_name' => SORT_ASC],
              'desc' => ['support.support_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.email' => SORT_ASC],
              'desc' => ['support.email' => SORT_DESC],
        ];

         $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.no_hp' => SORT_ASC],
              'desc' => ['support.no_hp' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.company' => SORT_ASC],
              'desc' => ['support.company' => SORT_DESC],
        ];


        if (isset($_GET['ScheduleSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['shift', 'support', 'support.pos']);

        $query->andFilterWhere([
            'schedule_id' => $this->schedule_id,
            'shift.shift_id' => $this->shift_id,
            'is_dm' => $this->is_dm,
            'date' => $this->date
        ]);
        $query->andFilterWhere(['like', 'support.support_name', $this->support_id]);
        $query->andFilterWhere(['like', 'support_position.position_name', $this->position_name]);  
        
        return $dataProvider;
    }
}
 