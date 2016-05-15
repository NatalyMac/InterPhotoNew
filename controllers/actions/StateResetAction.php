<?php
namespace app\controllers\actions;


use Yii;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;


class StateResetAction extends \yii\rest\Action
{
    public $authModel = 'app\models\Users';

    /**
     * Sends info about Reset code - if used and valid time
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function run()
    {
        $response = \Yii::$app->response;

        if (!($resetCode = \Yii::$app->request->getHeaders()['reset-code']))
            throw new BadRequestHttpException ('Nothing to answer, you need to send reset code header', 400);

        $resetPass = $this->modelClass;

        if (!$authResetPass = $resetPass::findByResetCode($resetCode))
            throw new NotFoundHttpException('Incorrect reset code ', 404);

        $validDatetime = \Yii::$app->formatter->asDatetime($authResetPass->valid_at);
        $response->getHeaders()->set('reset-code used', $authResetPass->used);
        $response->getHeaders()->set('reset-code valid at', $validDatetime);

    }
}