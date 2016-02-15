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
            [['date', 'shift_start', 'shift_end'], 'safe'],
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
            'shift_start' => 'Shift Start',
            'shift_end' => 'Shift End',
            'pic_id' => 'Pic ID',
        ];
    }

    /*
        get relation
    */
    public function getPic()
    {
        return $this->hasOne(Pic::className(), ['pic_id' => 'pic_id'])->with(['pos']);
    }

}
