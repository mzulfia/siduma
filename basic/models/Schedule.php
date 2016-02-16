<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "schedule".
 *
 * @property integer $schedule_id
 * @property string $date
 * @property string $shift_start
 * @property string $shift_end
 * @property integer $pic_id
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'shift_id'], 'safe'],
            [['pic_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => 'Schedule ID',
            'date' => 'Date',
            'shift_id' => 'Shift ID',
        ];
    }

    /*
        get relation
    */
    public function getSupport()
    {
        return $this->hasOne(Support::className(), ['support_id' => 'support_id'])->with(['pos']);
    }

    public function getSupportName($id){
        $array  = Pic::find()->where('support_id = :support_id', [':support_id' => $id])->one();
        if($array == null){
            return "Kosong";
        } else {
            return $array->pic_name;
        }
    }

    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['shift_id' => 'shift_id']);
    }

    public function getListPosName(){
        $arrays  = PicPosition::findBySql("SELECT position_name FROM pic_position")->all();      
        $result = [];
        foreach($arrays as $array){
            array_push($result, $array->position_name);
        }
        return $result;
    }
    
}
