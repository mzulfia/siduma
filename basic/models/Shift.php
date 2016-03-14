<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shift".
 *
 * @property integer $shift_id
 * @property string $shift_name
 * @property string $shift_start
 * @property string $shift_end
 */
class Shift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shift_name', 'shift_start', 'shift_end'], 'required'],
            [['shift_start', 'shift_end'], 'safe'],
            [['shift_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shift_id' => 'Shift ID',
            'shift_name' => 'Shift Name',
            'shift_start' => 'Shift Start',
            'shift_end' => 'Shift End',
        ];
    } 

    public function getNameTime($id){
        $array  = Shift::find()->where('shift_id = :shift_id', [':shift_id' => $id])->one();
        if($array == null){
            return "Kosong";
        } else {
            return $array->shift_name . " " . $array->shift_start . "-" . $array->shift_end;
        }
    }

    public function getShift($time){
        if($time >= "07:00:00" AND $time < "16:00:00"){
            $model = Shift::find()->where('shift_start = "07:00:00"')->one();
        } else if($time >= "16:00:00" AND $time < "23:00:00"){
            $model = Shift::find()->where('shift_start = "16:00:00"')->one();
        } else{
            $model = Shift::find()->where('shift_start = "23:00:00"')->one();
        }

        return $model;   
    }
}
