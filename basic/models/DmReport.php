<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DmReport".
 *
 * @property integer $DmReport_id
 * @property integer $status
 * @property string $information
 * @property string $created_at
 * @property integer $service_family_id
 */
class DmReport extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','information'], 'required'],
            [['created_at'], 'safe'],
            [['status', 'support_id', 'service_family_id'], 'integer'],
            [['information'], 'string'],
            [['file_path'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_report_id' => 'DM Report ID',
            'status' => 'Status',
            'information' => 'Information',
            'created_at' => 'Created At',
            'support_id' => 'Reporter Name',
            'service_family_id' => 'Service Family',
            'file' => 'File'
        ];
    }

    /*
        get the relations
    */

    public function getService(){
        return $this->hasOne(ServiceFamily::className(), ['service_family_id' => 'service_family_id']);
    }

    public function getSupport(){
        return $this->hasOne(Support::className(), ['support_id' => 'support_id']);
    }

    /*
        getter
    */

    public function getNormalCondition($date, $service_family_id){
        $all = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM dm_report WHERE created_at BETWEEN :start AND :end AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();
        $normal = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS normal FROM dm_report WHERE created_at BETWEEN :start AND :end AND status = 2 AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();

        $result = 0.0;
        if($all[0]['total'] != 0)
            $result = ($normal[0]['normal']/$all[0]['total'])*100;

        return $result;
    }

    public function getWarningCondition($date, $service_family_id){
        $all = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM dm_report WHERE created_at BETWEEN :start AND :end AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();
        $warning = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS warning FROM dm_report WHERE created_at BETWEEN :start AND :end AND status = 1 AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();

        $result = 0.0;
        if($all[0]['total'] != 0)
            $result = ($warning[0]['warning']/$all[0]['total'])*100;

        return $result;
    }

    public function getCriticalCondition($date, $service_family_id){
        $all = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM dm_report WHERE created_at BETWEEN :start AND :end AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();
        $critical = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS critical FROM dm_report WHERE created_at BETWEEN :start AND :end AND status = 0 AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();

        $result = 0.0;
        if($all[0]['total'] != 0)
            $result = ($critical[0]['critical']/$all[0]['total'])*100;
        
        return $result;
    }

    public function getServiceDmReport($id){
        $model = DmReport::find()->where('service_family_id = :id', [':id' => $id])->orderBy('created_at desc')->limit(1)->one();
        return $model;
    }   

    /*
        setter
    */

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
                return false;
            }
        } else {
            return true;
        }
    }
}
