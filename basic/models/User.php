<?php
namespace app\models;

use Yii;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use kartik\password\StrengthValidator;

use app\models\Role;



class User extends ActiveRecord implements IdentityInterface
{
    public $auth_key;
    public $access_token;
    
    const ROLE_ADMINISTRATOR = 1;
    const ROLE_MANAGEMENT = 2;
    const ROLE_SUPERVISOR = 3;
    const ROLE_SUPPORT = 4; 
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
      
        return [
            [['username', 'password', 'salt_password'], 'required'],
            [['password'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'username'],
            [['username'], 'unique'],
            [['role_id'], 'integer'],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 50],
            [['salt_password'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt_password' => 'Salt Password',
            'role_id' => 'Role',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        //mencari user login berdasarkan accessToken dan hanya dicari 1.
        // $user = User::find()->where(['accessToken'=>$token])->one(); 
        // if(count($user)){
        //     return new static($user);
        // }
        // return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->salt_password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

     /*
        get relation
    */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['role_id' => 'role_id']);
    }

    public function getRoleId($id) 
    {
        $command = Yii::$app->getDb()->createCommand('SELECT role_id FROM user WHERE user_id = :user_id', [':user_id' => $id])->queryAll();

        return $command[0]['role_id'];
    }

    public function getRoleName($id) 
    {
        $command = Yii::$app->getDb()->createCommand('SELECT role_name FROM user, role WHERE user.role_id = role.role_id AND user_id = :user_id', [':user_id' => $id])->queryAll();

        return $command[0]['role_name'];
    }
    
    public function getManagementId($id) 
    {
        $command = Yii::$app->getDb()->createCommand('SELECT management_id FROM user, management WHERE user.user_id = management.user_id AND management.user_id = :user_id', [':user_id' => $id])->queryAll();

        return $command[0]['management_id'];
    }

    public function getSupervisorId($id) 
    {
        $command = Yii::$app->getDb()->createCommand('SELECT supervisor_id FROM user, supervisor WHERE user.user_id = supervisor.user_id AND supervisor.user_id = :user_id', [':user_id' => $id])->queryAll();

        return $command[0]['supervisor_id'];
    }
    
    public function getSupportId($id) 
    {
        $command = Yii::$app->getDb()->createCommand('SELECT support_id FROM user, support WHERE user.user_id = support.user_id AND support.user_id = :user_id', [':user_id' => $id])->queryAll();

        return $command[0]['support_id'];
    }
}
?>