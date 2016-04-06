<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_family".
 *
 * @property integer $service_family_id
 * @property string $service_name
 */
class ServiceFamily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_family';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name'], 'required'],
            [['service_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_family_id' => 'Service Family ID',
            'service_name' => 'Service Name',
        ];
    }

    public function getServiceName($id){
        $array  = ServiceFamily::find()->where('service_family_id = :service_family_id', [':service_family_id' => $id])->one();
        if($array == null){
            return null;
        } else {
            return $array->service_name;
        }
    }

    public function getServiceIcon(){
        $model = ServiceFamily::find()->where('service_name = "AP2T" OR service_name = "P2APST" OR service_name = "BBO" OR service_name = "APKT"')->orderBy('service_family_id')->all();
        if(!empty($model)){
            $text = '';
            for($i=0; $i<sizeof($model); $i++){
                if($i == sizeof($model)-1){
                    $text .= $model[$i]['service_name'];
                } else{
                    $text .= $model[$i]['service_name'] . "/";
                }
            }
            return $text;
        } else {
            return null;    
        }
    }

    public function getServiceOthers(){
        $model = ServiceFamily::find()->where('service_name != "AP2T" AND service_name != "P2APST" AND service_name != "BBO" AND service_name != "APKT"')->orderBy('service_family_id')->all();
        if(!empty($model)){
            $text = '';
            for($i=0; $i<sizeof($model); $i++){
                if($i == sizeof($model)-1){
                    $text .= $model[$i]['service_name'];
                } else{
                    $text .= $model[$i]['service_name'] . "/";
                }
            }
            return $text;
        } else {
            return null;            
        }
    }
}
