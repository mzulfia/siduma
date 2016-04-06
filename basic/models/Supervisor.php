<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supervisor".
 *
 * @property integer $supervisor_id
 * @property string $spv_name
 * @property string $position
 * @property string $no_hp
 * @property string $email
 * @property string $image_path
 * @property integer $user_id
 */
class Supervisor extends \yii\db\ActiveRecord
{
    const IMAGE_PLACEHOLDER = '/uploads/profile_pictures/default_user.png';

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supervisor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spv_name', 'position', 'no_hp', 'email', 'file'], 'required'],
            [['user_id'], 'integer'],
            [['spv_name', 'position', 'no_hp', 'email'], 'string', 'max' => 50],
            [['image_path'], 'string', 'max' => 255],
            [['file'], 'file', 'maxSize'=>'200000'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supervisor_id' => 'Supervisor ID',
            'spv_name' => 'Supervisor Name',
            'position' => 'Position',
            'no_hp' => 'No Hp',
            'email' => 'Email',
            'image_path' => 'Image Path',
            'user_id' => 'User ID',
        ];
    }

    /*
        Get the relations
    */

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /*
        getter
    */

    public function getProfilePicture($id){
        $model = Supervisor::find()->where('supervisor_id = :id', [':id' => $id])->one();
        if(is_null($model->image_path)){
            return Supervisor::IMAGE_PLACEHOLDER;
        }
        else
        {
            return $model->image_path;    
        }
    }

    public function getName($id){
        $model = Supervisor::find()->where('supervisor_id = :id', [':id' => $id])->one();
        if(!empty($model->spv_name)){
           return $model->spv_name;
        }
        else
        {
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
                return true;
            }
        } else {
            return true;
        }
    }
}
