<?php

//namespace yii\rest;
namespace app\controllers;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;


class LogoutAction extends \yii\rest\Action
{
 
    public $typeAuth = 'Bearer ';
    public $realm = 'api';

    public function run()
    {    
       $matches = array();
       $tokenHeader = \Yii::$app->request->headers['authorization'];
   
        if (!is_scalar($tokenHeader))
            throw new UnprocessableEntityHttpException('Incorrect token', 422);

        if (!preg_match_all("/Bearer\s.{32}/", $tokenHeader, $matches))
            throw new UnprocessableEntityHttpException('Incorrect token', 422);

        $token = substr_replace($matches[0][0], '',0, strlen($this->typeAuth));

        if (!$token)  
            throw new UnprocessableEntityHttpException('Incorrect token', 422);
    
        $authModel=$this->modelClass;
    
        if (!$authUser = $authModel::resetToken($token))
            throw new UnprocessableEntityHttpException('No such token', 422);
    
        $this->setAuthenticateHeader();
    }

    public function setAuthenticateHeader()
        {
            $response = \Yii::$app->response;
            $response->getHeaders()->set('WWW-Authenticate', "Basic realm=\"{$this->realm}\"");
        }    
}
