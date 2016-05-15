<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\web\Controller;
use yii\behaviors\TimestampBehavior;
use yii\web\User;


class Users extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * This is the model class for table "users".
     *
     * @property integer $id
     * @property string $access_token
     * @property string $role
     * @property string $name
     * @property string $email
     * @property string $password
     * @property string $phone
     * @property integer $modified_at
     * @property integer $created_at
     *
     * @property AlbumClients[] $albumClients
     * @property Albums[] $albums
     * @property AuthAssignment[] $authAssignments
     * @property AuthItem[] $itemNames
     * @property Orders[] $orders
     * @property ResetPass[] $resetPasses
     * @property UserPackages[] $userPackages
     */

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_ASKRESET = 'askreset';
    const SCENARIO_UPDATE = 'update';

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
            
            [['role', 'name', 'email', 'password'], 'required'],
            [['email'], 'unique', 'on' => ['register', 'update']],
            [['role'], 'in', 'range' => ['admin', 'photographer', 'client']],
            [['modified_at', 'created_at'], 'safe'],
            [['password'], 'string', 'max' => 255],
            [['name', 'email'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 15],
            [['role', 'email'], 'safe', 'when'=> function ($model, $attribute)
                                        { return \Yii::$app->user->identity->role == 'admin';}], 
            // callback не срабатывает, валидация происходит при любом раскладе
            // дампила иходники, в классе Validator $when = null, при непосредственном вызове 
            // call_user_func($this->when, $model, $attribute)) - грит, что на входе ждет валидную коллбэк функцию,
            // а не массив или строку
            // увидеть бы рабочий вариант.. или все-таки сценарии.. или я неправильно функцию определяю
            ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {

        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['email', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'password', 'name', 'role',];
        $scenarios[self::SCENARIO_ASKRESET] = ['email'];
        $scenarios[self::SCENARIO_UPDATE] = ['password', 'name'];
        return $scenarios;
    }

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        // unset unsafely fields
        unset($fields['access_token'], $fields['password']);
        return $fields;
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return ['albums'];
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
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'modified_at' => 'Modified At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return array
     */
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
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
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
    public function getResetPasses()
    {
        return $this->hasMany(ResetPass::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUserPackages()
    {
        return $this->hasMany(UserPackages::className(), ['user_id' => 'id']);
    }
  

    /**
     * @param $email
     * @return null|static
     */
    public static function findByEmail($email)

    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {

        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @param $email
     * @param $password
     * @return Users|null
     */
    public function validateUser($email, $password)
    {

        $authUser = static::findByEmail($email);
        if ($authUser !== null and $password !== null) {

            if (!$authUser->validatePassword($password))
                false;

            $authUser->generateAccessToken();
            return $authUser;
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();

        if (!$this->update()) return false;

        return true;
    }

    /**
     * @param $password
     * @return bool
     */
    public function resetPassword($password)
    {
        $this->password = $password;

        if (!$this->save())
            return false;

        return true;
    }
    
    /**
     * @param $token
     * @return bool
     * @throws \Exception
     */
    public static function deleteToken($token)
    {
        $authUser = static::findIdentityByAccessToken($token);

        if (!$authUser) return false;

        $authUser->access_token = '';

        if (!$authUser->update()) return false;
        return true;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $result = static::findOne(['access_token' => $token]);
        return $result;
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);

    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }

            if (!($this->isnewRecord) and $this->isAttributeChanged('password')) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;

        } else {
            return false;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->roleAssignment();
            return true;
        }
    }

    /**
     * sets assignment role and user in RBAC model
     * @return bool
     */
    public function roleAssignment()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();

        foreach ($roles as $role) {
            if ($this->role == $role->name) {
                $current_role = $auth->createRole($role->name);
                $auth->assign($current_role, $this->id);
            }
        }
        return true;
    }

}




