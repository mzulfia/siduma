<?php

namespace app\components;
 
use app\models\User;
use yii\filters\AccessRule;

class AccessRules extends AccessRule {
 
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role == '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            // Check if the user is logged in, and the roles match
            }
            elseif (!$user->getIsGuest() && $role == $user->identity->role_id) {
                return true;
            }
        }
 
        return false;
    }
}

?>