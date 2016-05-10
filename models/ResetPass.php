<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class ResetPass extends \yii\db\ActiveRecord
{

    const SCENARIO_DO = 'do';

    public static function tableName()
    {
        return 'reset_pass';
    }

    public function rules()
    {
        return [
            [['email', 'used', 'user_id', 'reset_code'], 'required'],
            [['created_at', 'valid_at'], 'safe'],
            [['used', 'user_id'], 'integer'],
            [['email'], 'string', 'max' => 25],
            [['reset_code'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DO] = ['reset_code'];
        return $scenarios;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'created_at' => 'Created At',
            'valid_at' => 'Valid At',
            'used' => 'Used',
            'user_id' => 'Id User',
            'reset_code' => 'Reset Code',
        ];
    }

    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }
    
    public function generateResetCode()
    {
       return Yii::$app->security->generateRandomString();
    } 

    public function setResetCode($authUser)
    {
        $this->email = $authUser->email;
        $this->user_id = $authUser->id;
        $this->reset_code = $this->generateResetCode();
        $this->used = 0;
        $this->valid_at = time()+3600;
        
        if (!$this->save()) 
            return false;
        
        return $this->reset_code;
   }

    public static function findByResetCode($resetCode)
    {
        return static::findOne(['reset_code' => $resetCode]);
    }

    public function usedOne()
    {
        $this->used = 1;
        
        if (!$this->update()) 
            return false;
        
        return true;
    }

    public static function isSetCode($userId)
    {
        $resetCodes = null;
        $resetCodes = static::find()
            -> where([
            'user_id' => $userId,
            'used'    => 0,
             ])
            ->andWhere(['>','created_at', time() - 600 ])
            ->all();

            return count($resetCodes);
    }
}
