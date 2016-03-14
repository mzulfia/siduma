<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_area".
 *
 * @property integer $support_area_id
 * @property integer $support_id
 * @property integer $service_family_id
 *
 * @property ServiceFamily $serviceFamily
 * @property Support $support
 */
class SupportArea extends \yii\db\ActiveRecord
{
    public $support_name;
    public $service_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_id', 'service_family_id'], 'integer'],
            [['support_name', 'service_name', 'service_family_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_area_id' => 'Support Area ID',
            'support_id' => 'Support ID',
            'service_family_id' => 'Service Family',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceFamily()
    {
        return $this->hasOne(ServiceFamily::className(), ['service_family_id' => 'service_family_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupport()
    {
        return $this->hasOne(Support::className(), ['support_id' => 'support_id']);
    }

    public function getServiceInCharge($id){
        $model = SupportArea::find()->where('support_id = :id', [':id' => $id])->all();
        if(sizeof($model) == 1){
            return ServiceFamily::getServiceName($model[0]['service_family_id']);
        } else if(sizeof($model) > 1){
            $service_name = '';
            for($i=0; $i < sizeof($model); $i++){
                if($i == sizeof($model)-1)
                    $service_name .= ServiceFamily::getServiceName($model[$i]['service_family_id']);
                else
                    $service_name .= ServiceFamily::getServiceName($model[$i]['service_family_id']) . "/";
            }
            return $service_name;
        } else {
            return null;
        }
    }

    public function getTeamIconNow(){
        date_default_timezone_set("Asia/Jakarta");
        $model = Yii::$app->getDb()->createCommand('SELECT support.support_id, support_name, email, no_hp, support_position_id, GROUP_CONCAT(support_area.service_family_id separator ", ") FROM support LEFT JOIN schedule ON support.support_id = schedule.support_id LEFT JOIN support_area ON support.support_id = support_area.support_id WHERE `date` = :dt AND shift_id = :shift_id AND is_dm = 0  AND (service_family_id = 3 OR service_family_id = 4 OR service_family_id = 5 OR service_family_id = 6) GROUP BY support.support_id ORDER BY service_family_id', [':dt' => date('Y-m-d'), ':shift_id' => Shift::getShift(date('H:i:s'))->shift_id])->queryAll();
        if(!empty($model)){
            return $model;
        } else{
            return null;
        }
    }

    public function getTeamOthersNow(){
        date_default_timezone_set("Asia/Jakarta");
        $model = Yii::$app->getDb()->createCommand('SELECT support.support_id, support_name, email, no_hp, support_position_id FROM support LEFT JOIN schedule ON support.support_id = schedule.support_id LEFT JOIN support_area ON support.support_id = support_area.support_id WHERE `date` = :dt AND shift_id = :shift_id AND is_dm = 0  AND (service_family_id != 3 AND service_family_id != 4 AND service_family_id != 5 AND service_family_id != 6) GROUP BY support.support_id ORDER BY service_family_id', [':dt' => date('Y-m-d'), ':shift_id' => Shift::getShift(date('H:i:s'))->shift_id])->queryAll();
        if(!empty($model)){
            return $model;
        } else{
            return null;
        }
    }
}
