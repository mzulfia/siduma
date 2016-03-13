<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report_support".
 *
 * @property integer $report_support_id
 * @property string $information
 * @property string $file_path
 * @property string $created_at
 * @property integer $support_id
 * @property integer $service_family_id
 *
 * @property ServiceFamily $serviceFamily
 * @property Support $support
 */
class SupportReport extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_family_id','information'], 'required'],
            [['created_at'], 'safe'],
            [['support_id', 'service_family_id'], 'integer'],
            [['file_path'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_report_id' => 'Support Report',
            'information' => 'Information',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'support_id' => 'Reporter Name',
            'service_family_id' => 'Service Family',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(ServiceFamily::className(), ['service_family_id' => 'service_family_id']);
    }

    public function getSupport()
    {
        return $this->hasOne(Support::className(), ['support_id' => 'support_id']);
    }

    /*
        getter
    */

    public function getServiceSupportReport($id){
        $model = SupportReport::find()->where('service_family_id = :id', [':id' => $id])->orderBy('created_at desc')->limit(1)->one();
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
