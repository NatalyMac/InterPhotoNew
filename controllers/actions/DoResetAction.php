<?php
namespace app\controllers\actions;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;
use yii\validators\EmailValidator;
use app\models\ResetPass;
use yii\swiftmailer\Mailer;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use app\models\Users;

class DoResetAction extends \yii\rest\Action
{
    public $authModel = 'app\models\Users';
    public $loginScenario =  Users::SCENARIO_LOGIN;
    public $doScenario =  ResetPass::SCENARIO_DO;
    public function run()
    {

        $params = \Yii::$app->request->getbodyParams();

        $authModel = new $this->authModel();
        $authModel->scenario = $this->loginScenario;
        $authModel->attributes = $params;

        $resetPass = new $this->modelClass();
        $resetPass->scenario =  $this->doScenario;
        $resetPass->attributes = $params;

        if ((!$authModel->validate()) or (!$resetPass->validate())) 
            throw new BadRequestHttpException('Email or(and) reset code or(and) password is (are) empty', 400);

        $email = $params['email'];
        $resetCode = $params['reset_code'];
        $password = $params['password'];

        if (!($authUser = $authModel->findByEmail($email)))
            throw new NotFoundHttpException('User was not found, check the email', 404);

        if (!($authResetPass = $resetPass->findByResetCode($resetCode)))
        	throw new NotFoundHttpException('User was not found, check the reset code', 404);;

        if (!($authUser->id == $authResetPass->user_id)) 
        	 throw new BadRequestHttpException('Email and reset code are dismatch each other', 400);

        if ($authResetPass->used == 1)
            throw new BadRequestHttpException('Reset code has been used', 400);
        
        if ((int)($authResetPass->valid_at - time()) < 0 ) 
        	throw new BadRequestHttpException('Reset code is expired', 400);
        
        if (!($authUser->resetPassword($password))) 
            throw new ServerErrorHttpException('Failed to action for unknown reason.');
        
        if (!$authResetPass->usedOne()) 
       	   throw new ServerErrorHttpException('Failed to action for unknown reason.');
    }
}
