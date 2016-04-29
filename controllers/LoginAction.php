<?php

//namespace yii\rest;
namespace app\controllers;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;


class LoginAction extends \yii\rest\Action
{
 
    public $typeAuth = 'Bearer ';
    

    public function run()
    {    
        $username = null;
        $password = null;
        // username and password from request

        if (strstr(\Yii::$app->request->headers['authorization'], 'Basic'))
            {
            if (!\Yii::$app->request->getAuthUser() 
               or (!\Yii::$app->request->getAuthpassword())) 
                throw new UnprocessableEntityHttpException('Incorrect username or password', 422);
            $username = \Yii::$app->request->getAuthUser();
            $password = \Yii::$app->request->getAuthpassword();
            }
            
        if (\Yii::$app->request->getbodyParams())
            {
            if ((!\Yii::$app->request->getbodyParam('username')
                or (!\Yii::$app->request->getbodyParam('password'))))
                throw new UnprocessableEntityHttpException('Incorrect username or password', 422);

            $username = \Yii::$app->request->getbodyParam('username');
            $password = \Yii::$app->request->getbodyParam('password');
            }

        $authModel=$this->modelClass;
        // validate username and password
        $authUser = $authModel::validateUser($username, $password);
        if (!$authUser)
            throw new UnprocessableEntityHttpException('Incorrect username or password', 422);
        // set autorization token in the header
        $this->setAutorizationHeader($authUser);
            return true;
    }
    

    public function setAutorizationHeader($authUser)
    {
       if (!$authUser) throw new  BadRequestHttpException('Bad Request',400);
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Autorization', $this->typeAuth.$authHeader);
      
    }
}