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
    //     return array_merge(parent::attributes(), ['pic_id']);
    // }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'pic_id', 'position_name'], 'safe'],
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

        // $dataProvider->sort->attributes['pic_name'] = [
        //       'asc' => ['pic.pic_name' => SORT_ASC],
        //       'desc' => ['pic.pic_name' => SORT_DESC],
        // ];

        // $dataProvider->sort->attributes['relPic.pic_position_id'] = [
        //       'asc' => ['relPic.relPicPos.position_name' => SORT_ASC],
        //       'desc' => ['relPic.relPicPos.position_name' => SORT_DESC],
        // ];

        $dataProvider->sort->attributes['position_name'] = [
              'asc' => ['position_name' => SORT_ASC],
              'desc' => ['position_name' => SORT_DESC],
        ];

        if (isset($_GET['ScheduleSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['pic', 'pic.pos']);

        // $query->andFilterWhere('like', 'pic.pic_name', $this->pic->pic_name);

        $query->andFilterWhere([
            'schedule_id' => $this->schedule_id,
            'date' => $this->date,
        ]);
        
        $query->andFilterWhere(['like', 'pic_name', $this->pic_id]);
        $query->andFilterWhere(['like', 'position_name', $this->position_name]);

        return $dataProvider;
    }
}
 