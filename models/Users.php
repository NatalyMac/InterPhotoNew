<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\controllers\auth\RbacController;
use app\models\auth\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $access_token
 * @property string $role
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string $modified_at
 * @property string $created_at
 * @property string $auth_key
 * @property string $password_hash
 *
 * @property AlbumClients[] $albumClients
 * @property Albums[] $albums
 * @property Orders[] $orders
 * @property UserPackages[] $userPackages
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'name', 'username', 'password'], 'required'],
            [['role'], 'string'],
            [['modified_at', 'created_at'], 'safe'],
            [['access_token'], 'string', 'max' => 100],
            [['name', 'username', 'password'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['username'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'role' => 'Role',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'phone' => 'Phone',
            'modified_at' => 'Modified At',
            'created_at' => 'Created At',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumClients()
    {
        return $this->hasMany(AlbumClients::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Albums::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPackages()
    {
        return $this->hasMany(UserPackages::className(), ['user_id' => 'id']);
    }

    // поиск
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    // хелперы
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
 
    //аутентификация
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
        
        return static::findOne(['access_token' => $token]);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey($this->auth_key);
                $this->setPassword($this->password);}

            if ($this->isAttributeChanged('password')){
            $this->setPassword($this->password);   }
            return true;
            
        } else {
            return false;
        }
        
    }
  
}

