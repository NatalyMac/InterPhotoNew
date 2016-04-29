<?php

namespace yii\rest;
namespace app\controllers;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;

class LoginAction extends \yii\rest\Action
{
    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    
    public function run()
    {    
        $username = null;
        $password = null;
        // username and password from request
        if (strstr(\Yii::$app->request->headers['authorization'], 'Basic'))
            {
                $username = \Yii::$app->request->getAuthUser();
                $password = \Yii::$app->request->getAuthpassword();
            }
        if (\Yii::$app->request->bodyParams)
            {
                $username = \Yii::$app->request->bodyParams['username'];
                $password = \Yii::$app->request->bodyParams['password'];
            }
        if (!$username or !$password) 
             throw new UnprocessableEntityHttpException('Incorrect username or password', 422);

        $authModel=$this->modelClass;
        // validate username and password
        $authUser = $authModel::validateUser($username, $password);
        if (!$authUser)
            throw new UnprocessableEntityHttpException('Incorrect username or password', 422);
        // set autorization token in the header
        $this->setAutorizationHeader($authUser);
            return true;
    }

/*

 public function actionLogin()
    {
        $username = null;
        $password = null;
        // username and password from request
        if (strstr(\Yii::$app->request->headers['authorization'], 'Basic'))
            {
                $username = \Yii::$app->request->getAuthUser();
                $password = \Yii::$app->request->getAuthpassword();
            }
        if (\Yii::$app->request->bodyParams)
            {
                $username = \Yii::$app->request->bodyParams['username'];
                $password = \Yii::$app->request->bodyParams['password'];
            }
        if (!$username or !$password) 
             throw new UnprocessableEntityHttpException('Incorrect username or password', 422);

        $authModel=$this->modelClass;
        // validate username and password
        $authUser = $authModel::validateUser($username, $password);
        if (!$authUser)
            throw new UnprocessableEntityHttpException('Incorrect username or password', 422);
        // set autorization token in the header
        $this->setAutorizationHeader($authUser);
            return true;
    }
    */