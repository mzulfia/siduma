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
            [['date', 'shift_id', 'support_id','is_dm'], 'safe'],
            [['shift_id', 'is_dm'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => 'Support',
            'date' => 'Date',
            'shift_id' => 'Shift',
            'support_id' => 'Support ID',
            'is_dm' => 'Is Duty Manager',
        ];
    }

    /*
        get relation
    */
    public function getSupport()
    {
        return $this->hasOne(Support::className(), ['support_id' => 'support_id'])->with(['pos']);
    }

    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['shift_id' => 'shift_id']);
    }

    public function getSupportName($id){
        $array  = Support::find()->where('support_id = :support_id', [':support_id' => $id])->one();
        if($array == null){
            return "Kosong";
        } else {
            return $array->support_name;
        }
    }

    public function getShiftStart($id){
        $array  = Shift::find()->where('shift_id = :shift_id', [':shift_id' => $id])->one();
        if($array == null){
            return "Kosong";
        } else {
            return $array->shift_start;
        }
    }

    public function getShiftEnd($id){
        $array  = Shift::find()->where('shift_id = :shift_id', [':shift_id' => $id])->one();
        if($array == null){
            return "Kosong";
        } else {
            return $array->shift_end;
        }
    }

    public function getListPosName(){
        $arrays  = SupportPosition::findBySql("SELECT position_name FROM support_position")->all();      
        $result = [];
        foreach($arrays as $array){
            array_push($result, $array->position_name);
        }
        return $result;
    }
}
