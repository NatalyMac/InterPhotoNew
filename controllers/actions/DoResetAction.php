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

class DoResetAction extends \yii\rest\Action
{
    public $authModel = 'app\models\Users';
    
    public function run()
    {

        if (!\Yii::$app->request->getbodyParams())
    	throw new BadRequestHttpException('Email or(and) reset code or(and) password is (are) empty', 400);
        
        if ((!($email = \Yii::$app->request->getbodyParam('email'))
            or (!($resetCode = \Yii::$app->request->getbodyParam('reset-code'))))
            or (!($password = \Yii::$app->request->getbodyParam('password'))))
            throw new BadRequestHttpException('Email or(and) reset code or(and) password is (are) empty', 400);

            //$email = \Yii::$app->request->getbodyParam('email');
            //$resetCode = \Yii::$app->request->getbodyParam('reset-code');
            //$password = \Yii::$app->request->getbodyParam('password');
        
        $authModel=$this->authModel;

        if (!($authUser = $authModel::findByEmail($email)))
        //if (!$authUser)
            throw new NotFoundHttpException('User was not found, check the email', 404);

        $resetPass = $this->modelClass;
        
        if (!($authResetPass = $resetPass::findByResetCode($resetCode)))
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
