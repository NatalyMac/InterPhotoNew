<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use yii\base\ActionFilter;
use yii\web\Response;
use app\models\Users; 


class AuthController extends ActiveController 
{
    public $modelClass  = '\app\models\Users';
    public $realm = 'api';
    public $typeAuth = 'Bearer ';

    public function actions() 
    {   
        $actions = parent::actions();
        $actions ['login'] = [
            'class' => 'app\controllers\LoginAction',
            'modelClass' => $this->modelClass,
            ];
        $actions ['logout'] = [
            'class' => 'app\controllers\LogoutAction',
            'modelClass' => $this->modelClass,
            ];
         $actions ['ask-reset'] = [
            'class' => 'app\controllers\AskResetAction',
            'modelClass' => $this->modelClass,
            ];



            return $actions;
    }

    protected function verbs()
    {
    	$verbs = parent::verbs();
        $verbs['login']     = ['POST'];
        $verbs['logout']    = ['DELETE'];
        $verbs['ask-reset'] = ['POST'];
        return $verbs;
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

public function actionAskReset()
{
	var_dump('askreset');
}

public function actionDoReset()
{
	var_dump('doreset');
}

public function actionStateReset()
{
	var_dump('statereset');
}

public function actionLogout()
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
*/
//helpers
    // set and send token for validated user
    public function setAutorizationHeader($authUser)
    {
       if (!$authUser) throw new  BadRequestHttpException('Bad Request',400);
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Autorization', $this->typeAuth.$authHeader);
      
    }
    
    public function setAuthenticateHeader()
    {
     	$response = \Yii::$app->response;
        $response->getHeaders()->set('WWW-Authenticate', "Basic realm=\"{$this->realm}\"");
    }

}