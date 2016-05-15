<?php
namespace app\controllers\actions;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;


class AskResetAction extends \yii\rest\Action
{
    public $authModel = 'app\models\Users';

    /**
     * Sets reset code and send it via email
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $email = null;
        $params = \Yii::$app->request->getbodyParams();
        $authModel = new $this->authModel;
        $authModel->scenario = 'askreset';
        $authModel->attributes = $params;

        if (!$authModel->validate())
            throw new BadRequestHttpException('Email is empty', 400);

        $email = $params['email'];

        if (!($authUser = $authModel->findByEmail($email)))
            throw new NotFoundHttpException('User was not found, check the email', 404);

        $resetPass = new $this->modelClass;

        if ($resetPass->isSetCode($authUser->id))
            throw new BadRequestHttpException('Email with your reset code has been sent', 400);;

        if (!($resetCode = $resetPass->setResetCode($authUser)))
            throw new ServerErrorHttpException('Failed to action for unknown reason.');

        if (!$this->sendResetCode($resetCode, $email))
            throw new ServerErrorHttpException('Failed to action for unknown reason.');

        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
    }

    /**
     * @param $resetCode
     * @param $email
     * @return bool
     */
    public function sendResetCode($resetCode, $email)
    {
        if (Yii::$app->mailer->compose()
            ->setFrom('intersog.labs@gmail.com')
            ->setTo($email)
            ->setSubject('Reset Password Request')
            ->setTextBody('Dear ' . $email . '. You ask about reseting your password. Please use this code "' . $resetCode .
                '" to change your password. Regards, your Intersog team')
            ->send()
        )
            return true;

    }

}

