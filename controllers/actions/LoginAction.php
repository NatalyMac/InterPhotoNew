<?php

namespace app\controllers\actions;


use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use app\models\Users;

class LoginAction extends \yii\rest\Action
{

    public $typeAuth = 'Bearer ';
    public $loginScenario = Users::SCENARIO_LOGIN;

    /**
     * Login
     * @return bool
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function run()
    {
        $params['email'] = \Yii::$app->request->getAuthUser();
        $params['password'] = \Yii::$app->request->getAuthpassword();
        $authModel = new $this->modelClass;
        $authModel->scenario = $this->loginScenario;
        $authModel->attributes = $params;

        if (!$authModel->validate())
            throw new BadRequestHttpException('Email or(and) password is(are) empty', 400);

        if (!($authUser = $authModel->validateUser($params['email'], $params['password'])))
            throw new NotFoundHttpException('User was not found, check the email or password', 404);

        // set autorization token in the header
        $this->setAutorizationHeader($authUser);
        return true;
        $authModel->validateUser($params['email'], $params['password']);
    }

    /**
     * Sets autorization token as a header
     * @param $authUser
     */
    public function setAutorizationHeader($authUser)
    {
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Authorization', $this->typeAuth . $authHeader);
    }

}