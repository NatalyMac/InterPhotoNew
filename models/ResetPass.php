<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class ResetPass extends \yii\db\ActiveRecord
{
    /**
     * This is the model class for table "reset_pass".
     *
     * @property integer $id
     * @property string $email
     * @property integer $created_at
     * @property integer $valid_at
     * @property integer $used
     * @property integer $user_id
     * @property string $reset_code
     *
     * @property Users $user
     */

    const SCENARIO_DO = 'do';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reset_pass';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DO] = ['reset_code'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function generateResetCode()
    {
        return Yii::$app->security->generateRandomString();
    }

    /**
     * @param $authUser
     * @return bool|string
     */
    public function setResetCode($authUser)
    {
        $this->email = $authUser->email;
        $this->user_id = $authUser->id;
        $this->reset_code = $this->generateResetCode();
        $this->used = 0;
        $this->valid_at = time() + 3600;

        if (!$this->save())
            return false;

        return $this->reset_code;
    }

    /**
     * @param $resetCode
     * @return null|static
     */
    public static function findByResetCode($resetCode)
    {
        return static::findOne(['reset_code' => $resetCode]);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function usedOne()
    {
        $this->used = 1;

        if (!$this->update())
            return false;

        return true;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function isSetCode($userId)
    {
        $resetCodes = null;
        $resetCodes = static::find()
            ->where([
                'user_id' => $userId,
                'used' => 0,
            ])
            ->andWhere(['>', 'created_at', time() - 600])
            ->all();

        return count($resetCodes);
    }
}
