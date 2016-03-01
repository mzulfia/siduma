<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $report_id
 * @property integer $status
 * @property string $information
 * @property string $created_at
 * @property integer $service_family_id
 */
class Report extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'report_id' => 'Report ID',
            'status' => 'Status',
            'information' => 'Information',
            'created_at' => 'Created At',
            'support_id' => 'Support ID',
            'service_family_id' => 'Service Family ID',
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

    public function getOkCondition($date, $service_family_id){
        $all = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM report WHERE created_at BETWEEN :start AND :end AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();
        $ok = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS ok FROM report WHERE created_at BETWEEN :start AND :end AND status = 1 AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();

        $result = 0.0;
        if($all[0]['total'] != 0)
            $result = ($ok[0]['ok']/$all[0]['total'])*100;

        return $result;
    }

    public function getBadCondition($date, $service_family_id){
        $all = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM report WHERE created_at BETWEEN :start AND :end AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();
        $bad = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS bad FROM report WHERE created_at BETWEEN :start AND :end AND status = 0 AND service_family_id = :service_family_id', [':start' => explode(" - ", $date)[0], ':end' => date('Y-m-d', strtotime(explode(" - ", $date)[1] . ' +1 day')), ':service_family_id' => $service_family_id])->queryAll();

        $result = 0.0;
        if($all[0]['total'] != 0)
            $result = ($bad[0]['bad']/$all[0]['total'])*100;
        
        return $result;
    }

    public function getServiceReport($id){
        $model = Report::find()->where('service_family_id = :id', [':id' => $id])->orderBy('created_at desc')->limit(1)->one();
        return $model;
    }
}
