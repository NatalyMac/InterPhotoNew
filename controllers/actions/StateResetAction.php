<?php
namespace app\controllers\actions;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;
use yii\validators\EmailValidator;
use app\models\ResetPass;
use yii\swiftmailer\Mailer;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;


class StateResetAction extends \yii\rest\Action
{
    public $authModel = 'app\models\Users';
    
    public function run()
    {
    
        $request =  \Yii::$app->request;
        $response = \Yii::$app->response;

        if (!($resetCode = \Yii::$app->request->getHeaders()['reset-code']))
            throw new BadRequestHttpException ('Nothing to answer, you need to send reset code header', 400);

        $resetPass = $this->modelClass;

        if (!$authResetPass = $resetPass::findByResetCode($resetCode)) 
            throw new NotFoundHttpException('Incorrect reset code ', 404);

        $validDatetime = \Yii::$app->formatter->asDatetime($authResetPass->valid_at);
        $response->getHeaders()->set('reset-code used', $authResetPass->used);
        $response->getHeaders()->set('reset-code valid at',$validDatetime);

    }
}