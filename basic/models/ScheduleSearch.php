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
            [['date', 'support_id', 'position_name'], 'safe'],
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

        // $dataProvider->sort->attributes['support_name'] = [
        //       'asc' => ['support.support_name' => SORT_ASC],
        //       'desc' => ['support.support_name' => SORT_DESC],
        // ];

        // $dataProvider->sort->attributes['relPic.support_position_id'] = [
        //       'asc' => ['relPic.relPicPos.position_name' => SORT_ASC],
        //       'desc' => ['relPic.relPicPos.position_name' => SORT_DESC],
        // ];

        // $dataProvider->sort->attributes['position_name'] = [
        //       'asc' => ['position_name' => SORT_ASC],
        //       'desc' => ['position_name' => SORT_DESC],
        // ];

        if (isset($_GET['ScheduleSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        // $query->joinWith(['support', 'support.pos']);

        // $query->andFilterWhere('like', 'support.support_name', $this->support->support_name);

        $query->andFilterWhere([
            'schedule_id' => $this->schedule_id,
            'date' => $this->date,
        ]);
        
        // $query->andFilterWhere(['like', 'support_name', $this->support_id]);
        // $query->andFilterWhere(['like', 'position_name', $this->position_name]);

        return $dataProvider;
    }
}
 