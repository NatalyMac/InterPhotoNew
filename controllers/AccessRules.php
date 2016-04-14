<?php

namespace  app\controllers;

use app\models\Users; 
 
class AccessRules extends \yii\filters\AccessRule {
 
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
       if (empty($this->roles)) {
            return true;}
        
        foreach ($this->roles as $role) 
        {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;}
            } 
            
            elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;}
            } 
        // проверяем, что пользователь залогиненный и его роль совпадает с ролью 
        //в правилах
       elseif (!$user->getIsGuest() && $role === $user->identity->role) 
          return true;
                
        }
 
        return false;
    }
}
