<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property integer $support_id
 * @property integer $
 * @property string $support_name
 * @property string $company
 * @property integer $no_hp
 * @property integer $support_position_id
 * @property integer $user_id
 */
class Support extends \yii\db\ActiveRecord
{
    const IMAGE_PLACEHOLDER = '/uploads/profile_pictures/default_user.png';

    public $file;
    public $support_area; 
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_position_id', 'user_id'], 'integer'],
            [['support_name', 'company', 'email', 'no_hp'], 'string', 'max' => 50],
            [['image_path'], 'string', 'max' => 255],
            [['file'], 'file', 'maxSize'=>'200000'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png'],
            [['support_area'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_id' => 'Support ID',
            'support_name' => 'Name',
            'company' => 'Company',
            'no_hp' => 'No Hp',
            'email' => 'Email',
            'support_position_id' => 'Position',
            'user_id' => 'User ID',
            'file' => 'Profile Picture'
        ];
    }

    /*
        get relation
    */
    public function getPos()
    {
        return $this->hasOne(SupportPosition::className(), ['support_position_id' => 'support_position_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['support_id' => 'support_id']);
    }
    
    public function getService()
    {
        return $this->hasMany(SupportArea::className(), ['support_id' => 'support_id']);
    }

    public function getProfilePicture($support_id){
        $model = Support::find()->where('support_id = :support_id', [':support_id' => $support_id])->one();
        if(is_null($model->image_path)){
            return SUPPORT::IMAGE_PLACEHOLDER;
        }
        else
        {
            return $model->image_path;    
        }
    }

    public function getName($id){
        $model = Support::find()->where('support_id = :id', [':id' => $id])->one();
        if(!empty($model->support_name)){
           return $model->support_name;
        }
        else
        {
            return null;    
        }
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

    public function deleteImage() {
       if(!empty($this->image_path)){
            $image = getcwd() . "/" . $this->image_path;
            if(file_exists($image)){
                if (unlink($image)) {
                    $this->image_path = null;
                    $this->save();
                    return true;
                }    
            } else {
            }
                return true;
        } else {
            return true;
        }
    }

    /*
        setter
    */

     public function afterSave($insert, $changedAttributes){
        if(!empty($this->support_area)){
            \Yii::$app->db->createCommand()->delete('support_area', 'support_id = '.(int) $this->support_id)->execute(); //Delete existing value
            foreach ($this->support_area  as $id) { //Write new values
                $sa = new SupportArea();
                $sa->support_id = $this->support_id;
                $sa->service_family_id = $id;
                $sa->save();
            }
        }
    }

}
