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
    public $file;

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
            [['date', 'shift_id', 'support_id', 'is_dm'], 'required'],
            [['shift_id', 'is_dm'], 'integer'],
            [['file'], 'file', 'maxSize'=>'1000000'],
            [['file_path'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx']
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
            'support_id' => 'Support',
            'is_dm' => 'Is Duty Manager',
            'file' => 'File'
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

    public function getNextSchedule($support_id){
        $datetime = new \DateTime('tomorrow');
        $model = Schedule::find()->where('date = :date AND support_id = :support_id', [':date' => $datetime->format('Y-m-d'), ':support_id' => $support_id])->one();
        if(!empty($model))
            return $model;
        else
            return null;
    }

    public function getDmNow(){
        date_default_timezone_set("Asia/Jakarta");
        $model = Schedule::find()->where('date = :date AND shift_id = :shift_id AND is_dm = 1', [':date' => date('Y-m-d'), ':shift_id' => Shift::getShift(date('H:i:s'))->shift_id])->one();
        if(!empty($model)){
            return $model;
        } else{
            return null;
        }
    }

    public function getDmNext($date, $time){
        date_default_timezone_set("Asia/Jakarta");
        $model = Schedule::find()->where('date = :date AND shift_id = :shift_id AND is_dm = 1', [':date' => $date, ':shift_id' => Shift::getShiftNext($time)])->one();
        if(!empty($model)){
            return $model;
        } else{
            return null;
        }
    }

    public function getTeamNow(){
        date_default_timezone_set("Asia/Jakarta");
        $model = Schedule::find()->where('date = :date AND shift_id = :shift_id AND is_dm = 0', [':date' => date('Y-m-d'), ':shift_id' => Shift::getShift(date('H:i:s'))->shift_id])->all();
        if(!empty($model)){
            return $model;
        } else{
            return null;
        }
    }

    public function getIsNotExist($date, $shift_id, $support_id){
        $model = Schedule::find()->where('date = :date AND shift_id = :shift_id AND support_id = :support_id', [':date' => $date, ':shift_id' => $shift_id, ':support_id' => $support_id])->one();
        if(empty($model)){
            return true;
        } else{
            return true;
        }
    }

    public function getIsNotExistDM($date, $shift_id){
        $model = Schedule::find()->where('date = :date AND shift_id = :shift_id AND is_dm = 1', [':date' => $date, ':shift_id' => $shift_id])->all();
        // return sizeof($model);
        if(empty($model)){
            return 0;
        } else{
            if(sizeof($model) > 1)
                return 2;
            else
                return 1;
        }
    }

    /*
        setter
    */

    public function setDM($start, $end, $shift_id){
        $list_support = Yii::$app->getDb()->createCommand('SELECT support_id FROM schedule WHERE date BETWEEN :start AND :end AND shift_id = :shift_id', [':start' => $start, ':end' => $end, ':shift_id' => $shift_id])->queryAll();
        $list_date = Yii::$app->getDb()->createCommand('SELECT DISTINCT date FROM schedule WHERE date BETWEEN :start AND :end AND shift_id = :shift_id', [':start' => $start, ':end' => $end, ':shift_id' => $shift_id])->queryAll();


        for($i = 0; $i < sizeof($list_date); $i++){
            $list_support = Yii::$app->getDb()->createCommand('SELECT support_id FROM schedule WHERE date = :dt AND shift_id = :shift_id', [':dt' => $list_date[$i]['date'], ':shift_id' => $shift_id])->queryAll();
            $temp_sup = [];
            for($j = 0; $j < sizeof($list_support); $j++){
                array_push($temp_sup, $list_support[$j]['support_id']);
            }

            $fix_support_id = $temp_sup[rand(0, sizeof($temp_sup)-1)];
            $model  = Schedule::find()->where('date = :dt AND shift_id = :shift_id AND support_id = :support_id', [':dt' => $list_date[$i]['date'], ':shift_id' => $shift_id, ':support_id' => $fix_support_id])->one();
            $model->is_dm = 1;
            $model->save(false);
        }
       
        return true;
    }

    public function getIsDmNow($date, $shift_id, $support_id){
        $model  = Schedule::find()->where('date = :date AND support_id = :support_id AND shift_id = :shift_id', [':date' => $date, ':support_id' => $support_id, ':shift_id' => $shift_id])->one();
        if(!empty($model))
        {
            return ($model->is_dm == 1);
        }
        else
        {
            return false;
        } 
    }  

    public function getIsSupportNow($date, $shift_id, $support_id){
        $model  = Schedule::find()->where('date = :date AND support_id = :support_id AND shift_id = :shift_id', [':date' => $date, ':support_id' => $support_id, ':shift_id' => $shift_id])->one();
        if(!empty($model))
        {
            return true;
        }
        else
        {
            return false;
        } 
    } 

    public function deleteFile() {
        if(!empty($this->file_path)){
            $file = getcwd() . "/" . $this->file_path;
            if(file_exists($file)){
                if (unlink($file)) {
                    $this->file_path = null;
                    $this->save();
                    return true;
                }    
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}
