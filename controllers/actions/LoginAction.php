<?php

namespace app\controllers\actions;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;


class LoginAction extends \yii\rest\Action
{
 
    public $typeAuth = 'Bearer ';
    

    public function run()
    {    
        $email = null;
        $password = null;
        // username and password from request
        if ($this->headerParams())
        {
            $email = $this->headerParams()['email'];
            $password =$this->headerParams()['password'];    
        } else {
            if ($this->bodyParams())
            {
                $email = $this->bodyParams()['email'];
                $password = $this->bodyParams()['password'];    
            }
        }

        $authModel=$this->modelClass;
        // validate username and password
        if (!$authUser = $authModel::validateUser($email, $password))
        //if (!$authUser)
            throw new NotFoundHttpException('User was not found, check the email or password', 404);
        // set autorization token in the header
        $this->setAutorizationHeader($authUser);
            return true;
    }
    

    public function setAutorizationHeader($authUser)
    {
       if (!$authUser) throw new  BadRequestHttpException('Email or(and) password is (are) empty',400);
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Autorization', $this->typeAuth.$authHeader);
      
    }
    
    public function headerParams()
    {
        $params = null;
        if (strstr(\Yii::$app->request->headers['authorization'], 'Basic'))
            {
            if (!\Yii::$app->request->getAuthUser() 
               or (!\Yii::$app->request->getAuthpassword())) 
                throw new BadRequestHttpException('Email or(and) password is (are) empty', 400);
            $params['email'] = \Yii::$app->request->getAuthUser();
            $params['password'] = \Yii::$app->request->getAuthpassword();
            }
        return $params;
    }

    public function bodyParams()
    {
         $params = null;

        if (!\Yii::$app->request->getbodyParams())
           throw new BadRequestHttpException('Email or(and) password is (are) empty', 400);
        
        if ((!($params['email'] = \Yii::$app->request->getbodyParam('email'))
            or (!($params['password'] = \Yii::$app->request->getbodyParam('password')))))
                throw new BadRequestHttpException('Email or(and) password is (are) empty', 400);

        //$params['email'] = \Yii::$app->request->getbodyParam('email');
        //$params['password'] = \Yii::$app->request->getbodyParam('password');
            return $params;
    }
}