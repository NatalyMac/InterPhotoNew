<?php

namespace app\controllers\actions;


use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;


class LogoutAction extends \yii\rest\Action
{

    public $typeAuth = 'Bearer ';
    public $realm = 'api';

    /**
     * Logout
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function run()
    {
        $matches = array();
        $tokenHeader = \Yii::$app->request->headers['authorization'];
        if (!preg_match_all("/Bearer\s.{32}/", $tokenHeader, $matches))
            throw new BadRequestHttpException('Incorrect token', 400);

        $token = substr_replace($matches[0][0], '', 0, strlen($this->typeAuth));

        $authModel = $this->modelClass;

        if (!$authUser = $authModel::deleteToken($token))
            throw new NotFoundHttpException('There is not such token', 404);

        $this->setAuthenticateHeader();
    }

    /**
     * Sets autorization header telling that you need to be authenticated
     */
    public function setAuthenticateHeader()
    {
        $response = \Yii::$app->response;
        $response->getHeaders()->set('WWW-Authenticate', "Basic realm=\"{$this->realm}\"");
    }
}
