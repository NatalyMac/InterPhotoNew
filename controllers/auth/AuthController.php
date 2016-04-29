<?php
namespace app\controllers;


use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use yii\base\ActionFilter;
use yii\web\Response;

class AuthController extends ActiveController 
{

public function actionLogin()
{
	$params = \Yii::$app->request->queryParams;
    if ($username = $params['username'] and $password = $params['password']
    {	
        if ($this->validateUser($username, $password)) return true;

    } else {
        throw new UnprocessableEntityHttpException('Incorrect username or password', 422);
        return false;
        } 
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
	var_dump('logout');
}

	public function validateUser($username, $password)
    {
        $authUser = null;
        $authModel=$this->authModel;
        $user = $authModel::findByUsername($username);
                       
        if($user!=null and $password!=null) {
            if($user->validatePassword($password)) {
               $authUser = $user;
               $this->setToken($authUser);
            }
            return $authUser;
        }   
    }
    
    // set and send token for validated user
    public function setToken($authUser)
    {
        if (!$authUser) throw new  BadRequestHttpException('Bad Request',400);
         
        $authUser->generateAccessToken();
        
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Autorization', 'Bearer '.$authHeader);
    }


}