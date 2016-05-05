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



class AskResetAction extends \yii\rest\Action
{
    public $authModel = 'app\models\Users';
    
    public function run()
    {
        if (!\Yii::$app->request->getbodyParams())
             throw new BadRequestHttpException('Email is  empty', 400);
            
        if (!($email = \Yii::$app->request->getbodyParam('email')))
           throw new BadRequestHttpException('Email is empty', 400);

        //$email = \Yii::$app->request->getbodyParam('email');
            
        $validator = new \yii\validators\EmailValidator();      
    
        if (!$validator->validate($email, $error)) 
            throw new BadRequestHttpException('Email is empty', 400);

        $authModel=$this->authModel;

        if (!($authUser = $authModel::findByEmail($email)))
            throw new NotFoundHttpException('User was not found, check the email', 404);
    
        $resetPass = new $this->modelClass;
        if ($resetPass->isSetCode($authUser->id)) 
           throw new BadRequestHttpException('Email with your reset code have been sent', 400);;

        if (!($resetCode = $resetPass->setResetCode($authUser)))
           throw new ServerErrorHttpException('Failed to action for unknown reason.');
        
        if (!$this->sendResetCode($resetCode, $email))
           throw new ServerErrorHttpException('Failed to action for unknown reason.');
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
    }

    public function sendResetCode($resetCode, $email)
    {
        if (Yii::$app->mailer->compose()
            ->setFrom('intersog.labs@gmail.com')
            ->setTo($email)
            ->setSubject('Reset Password Request')
            ->setTextBody('Dear '.$email.'. You ask about reseting your password. Please use this code "'.$resetCode.'" to change your password. Regards, your Intersog team')
            ->send())
        return true;

    }

}

