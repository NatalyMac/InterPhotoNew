<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\controllers\auth\RbacController;
use app\models\auth\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
//use yii\filters\VerbFilter;
use yii\behaviors\TimestampBehavior;


class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_ASKRESET = 'askreset';
    const SCENARIO_UPDATE = 'update';
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['role', 'name', 'email', 'password'], 'required'],
            [['email'], 'unique', 'on' => ['register']],
            //[['email'], 'unique', 'on' => 'update'],
            [['role'], 'string'],
            [['role'], 'in', 'range' => ['admin', 'photographer', 'client']],
            [['modified_at', 'created_at'], 'safe'],
            //[['access_token'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 255], 
            [['name', 'email'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 15],
        ];
    }

public function scenarios()
    {
        
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] =    ['email', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'password', 'name', 'role', ];
        $scenarios[self::SCENARIO_ASKRESET] = ['email'];
        $scenarios[self::SCENARIO_UPDATE] =   ['password', 'name'];
        return $scenarios;
    }


public function fields()
{
    $fields = parent::fields();
    // unset unsafely fields
    unset($fields['access_token'], $fields['password']);
        return $fields;
}

public function extraFields()
{
    return ['albums'];
}

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'role' => 'Role',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'modified_at' => 'Modified At',
            'created_at' => 'Created At',
        ];
    }

public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                     \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'modified_at'],
                     \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_at'],
                ],
            ],
        ];
    }
    
    public function getAlbumClients()
    {
        return $this->hasMany(AlbumClients::className(), ['user_id' => 'id']);
    }

   
    public function getAlbums()
    {
        return $this->hasMany(Albums::className(), ['user_id' => 'id']);
    }

  
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    
    public function getUserPackages()
    {
        return $this->hasMany(UserPackages::className(), ['user_id' => 'id']);
    }

    
    public static function findByEmail($email)
    //!!!!!!
    {
        return static::findOne(['email' => $email]);
    }

    // helpers !!!!!!

   public function validatePassword($password)
    {

        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
//hash
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
        
        if (!$this->update()) return false;
         
             return true;
    }
 
    public function validateUser($email, $password)
    {   

        $authUser = static::findByEmail($email);
        if ($authUser!== null and $password !== null) 
        {
        
            if (!$authUser->validatePassword($password))  
                false;
        
                $authUser->generateAccessToken();
                return $authUser;
        }          
    }

    public function resetPassword($password)
    {   
        $this->password = $password;
        
        if (!$this->save())
            return false;
        
        return true;
    }


    public static function deleteToken($token)
    {
        $authUser = static::findIdentityByAccessToken($token);
        
        if (!$authUser) return false;
        
        $authUser->access_token = '';
        
        if (!$authUser->update()) return false;
            return true;
   }


    //authentication
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
      return $this->auth_key;
    }
 
    public function validateAuthKey($authKey)
    {
      return $this->getAuthKey() === $authKey;
    }
 
    public static function findIdentity($id)
    {
        return static::findOne(['id'=>$id, 'status'=>self::STATUS_ACTIVE]);
               
    }
 
    public static function findIdentityByAccessToken($token, $type = null)
    {   
        $result = static::findOne(['access_token' => $token]);
             return $result; 
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            if ($this->isNewRecord) 
            {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            
            if (!($this->isnewRecord) and $this->isAttributeChanged('password'))
            {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
               return true;

        } else {
           return false;
        }   
    }
    
    public function afterSave($insert, $changedAttributes)
    {   
        parent::afterSave($insert,$changedAttributes);
            if ($insert) 
                {
                    $this->roleAssignment();    
                    return true;
               }
    }
    public function roleAssignment()
    {
        $auth = Yii::$app->authManager;
        $roles=$auth->getRoles();

        foreach ($roles as $role) 
        {
            if ($this->role == $role->name)
               { 
                    $current_role = $auth->createRole($role->name);
                    $auth->assign($current_role, $this->id);
                }
        }
     return true;  
    }

}




