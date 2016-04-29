<?php

//namespace yii\rest;
namespace app\controllers;
//namespace yii;

use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;
use yii\validators\EmailValidator;



class AskResetAction extends \yii\rest\Action
{
public function run()
{
    if (!\Yii::$app->request->bodyParams) 
	    throw new UnprocessableEntityHttpException('Incorrect username or email', 422);
    
    $username = \Yii::$app->request->bodyParams['username'];
    $email = \Yii::$app->request->bodyParams['email'];
    $validator = new \yii\validators\EmailValidator();      
    
    if (!$username or !$validator->validate($email, $error)) 
        throw new UnprocessableEntityHttpException('Incorrect username or email', 422);

    $authModel=$this->modelClass;
    $authUser = $authModel::findByUsername($username);
    
    if (!$authUser)
        throw new UnprocessableEntityHttpException('Incorrect username', 422);
        
        var_dump($authUser);


}

}

/*
$email = 'test@example.com';
$validator = new yii\validators\EmailValidator();

if ($validator->validate($email, $error)) {
    echo 'Email is valid.';
} else {
    echo $error;
}
*/
