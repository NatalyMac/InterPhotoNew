<?php

namespace app\controllers;

use yii\rest\ActiveController;


class AuthsController extends ActiveController
{

    public $modelClass = '\app\models\ResetPass';
    public $realm = 'api';
    public $authModel = '\app\models\Users';
    public $typeAuth = 'Bearer ';

    /**
     * @return array of actions
     */
    public function actions()
    {
        $actions = parent::actions();
        /**
         * @api {post} /auths/login Login
         * @apiName Login
         * @apiGroup Auths
         *
         * @apiDescription Returns the access token for api
         *
         * @apiParam {String} Email
         * @apiParam {String} Password
         *
         * @apiSuccess {string} Access-token Access Token as header Autorization
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
         *
         *    Autorization →Bearer HP8h43Eb9LHJPUZAi3LKNcohZV9bQnN4
         *    Connection →Keep-Alive
         *    Content-Length →4
         *    Content-Type →application/json; charset=UTF-8
         *    Date →Mon, 02 May 2016 10:57:24 GMT
         *    Keep-Alive →timeout=5, max=100
         *    Server →Apache/2.4.7 (Ubuntu)
         *    X-Powered-By →PHP/5.5.9-1ubuntu4.16
         *
         * @apiError Not found <code>404</code> User was not found, check the email or password
         *
         * @apiErrorExample Error-Response:
         *     404 Not found
         *     {
         *      "name": "Not Found",
         *      "message": "User was not found, check the email or password",
         *      "code": 404,
         *      "status": 404,
         *      "type": "yii\\web\\NotFoundHttpException"
         *     }
         *
         * @apiError Bad request <code>400</code> Email or(and) password is (are) empty
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      "name": "Bad Request",
         *      "message": "Email or(and) password is (are) empty",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         */
        $actions ['login'] = [
            'class' => 'app\controllers\actions\LoginAction',
            'modelClass' => $this->authModel,
        ];
        /**
         * @api {delete} /auths/logout Logout
         * @apiName Logout
         * @apiGroup Auths
         *
         * @apiDescription Resets to empty the access token for api
         *
         * @apiParam {String} Access-token as header Autorizarion
         *
         * @apiSuccess {string} Www-Authenticate Header Www-Authenticate →Basic realm="api"
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
         *
         *   Connection →Keep-Alive
         *   Content-Length →0
         *   Content-Type →application/json; charset=UTF-8
         *   Date →Mon, 02 May 2016 11:16:43 GMT
         *   Keep-Alive →timeout=5, max=100
         *   Server →Apache/2.4.7 (Ubuntu)
         *   Www-Authenticate →Basic realm="api"
         *   X-Powered-By →PHP/5.5.9-1ubuntu4.16
         *
         *
         * @apiError 404 Not found <code>404</code> No such token
         *
         * @apiErrorExample Error-Response:
         *     404 Not found
         *     {
         *      "name": "Not Found",
         *      "message": "No such token",
         *      "code": 404,
         *      "status": 404,
         *      "type": "yii\\web\\NotFoundHttpException"
         *     }
         *
         * @apiError 400 Bad request <code>400</code> Incorrect token
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      "name": "Bad Request",
         *      "message": "Incorrect token",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         */
        $actions ['logout'] = [
            'class' => 'app\controllers\actions\LogoutAction',
            'modelClass' => $this->authModel,
        ];

        /**
         * @api {post} /auths/reset Reset-code set and email
         * @apiName AskReset
         * @apiGroup Auths
         *
         * @apiDescription For specific user as Email generates reset code and send it via email
         *
         * @apiParam {String} Email as body param
         *
         * @apiSuccess {string} sent-email reset code
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
         *
         *   Connection →Keep-Alive
         *   Content-Length →0
         *   Content-Type →application/json; charset=UTF-8
         *   Date →Mon, 02 May 2016 11:31:04 GMT
         *   Keep-Alive →timeout=5, max=100
         *   Server →Apache/2.4.7 (Ubuntu)
         *   X-Powered-By →PHP/5.5.9-1ubuntu4.16
         *
         *
         * @apiError 404 Not found <code>404</code> User was not found, check the email
         *
         * @apiErrorExample Error-Response:
         *     404 Not found
         *     {
         *      "name": "User was not found, check the email",
         *      "message": "No such token",
         *      "code": 404,
         *      "status": 404,
         *      "type": "yii\\web\\NotFoundHttpException"
         *     }
         *
         *
         * @apiError 400 Bad request <code>400</code> Email is  empty"
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      "name": "Bad Request",
         *      "message": "Email is  empty",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         *
         *
         * @apiError 400 Bad request <code>400</code> Email with your reset code have been sent
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      "name": "Bad Request",
         *      "message": "Email with your reset code have been sent",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         */
        $actions ['ask-reset'] = [
            'class' => 'app\controllers\actions\AskResetAction',
            'modelClass' => $this->modelClass,
        ];

        /**
         * @api {put} /auths/reset The password reset
         * @apiName DoReset
         * @apiGroup Auths
         *
         * @apiDescription Resets the password of user with specific email and reset code
         *
         * @apiParam {String} Email as body param
         * @apiParam {String} Reset-code as body param
         * @apiParam {String} New-password as body param
         *
         * @apiSuccess {String} changed-password for specific user
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 201 Created
         *
         *   Connection →Keep-Alive
         *   Content-Length →0
         *   Content-Type →application/json; charset=UTF-8
         *   Date →Mon, 02 May 2016 11:42:38 GMT
         *   Keep-Alive →timeout=5, max=100
         *   Server →Apache/2.4.7 (Ubuntu)
         *   X-Powered-By →PHP/5.5.9-1ubuntu4.16
         *
         *
         * @apiError 404 Not found <code>404</code> User was not found, check the email
         *
         * @apiErrorExample Error-Response:
         *     404 Not found
         *     {
         *      "name":  "Not Found",
         *      "message":  "User was not found, check the email",
         *      "code": 404,
         *      "status": 404,
         *      "type": "yii\\web\\NotFoundHttpException"
         *     }
         *
         *
         * @apiError 404 Not found <code>404</code> User was not found, check the reset code
         *
         * @apiErrorExample Error-Response:
         *     404 Not found
         *     {
         *      "name":  "Not Found",
         *      "message":  "User was not found, check the reset code",
         *      "code": 404,
         *      "status": 404,
         *      "type": "yii\\web\\NotFoundHttpException"
         *     }
         *
         *
         * @apiError 400 Bad request <code>400</code> Reset code has been used
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *       "name": "Bad Request",
         *       "message": "Reset code has been used",
         *       "code": 400,
         *       "status": 400,
         *       "type": "yii\\web\\BadRequestHttpException"
         *     }
         *
         *
         * @apiError 400 Bad request <code>400</code> Email or(and) reset code or(and) password is (are) empty
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      name": "Bad Request",
         *      "message": "Email or(and) reset code or(and) password is (are) empty",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         *
         *
         * @apiError 400 Bad request <code>400</code> Email and reset code are dismatch each other
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      name": "Bad Request",
         *      "message": "Email and reset code are dismatch each other",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         *
         *
         * @apiError 400 Bad request <code>400</code> Reset code is expired
         *
         * @apiErrorExample Error-Response:
         *     400 Bad request
         *     {
         *      name": "Bad Request",
         *      "message": "Reset code is expired",
         *      "code": 400,
         *      "status": 400,
         *      "type": "yii\\web\\BadRequestHttpException"
         *     }
         */

        $actions ['do-reset'] = [
            'class' => 'app\controllers\actions\DoResetAction',
            'modelClass' => $this->modelClass,
        ];

        /**
         * @api {head} /auths/reset State of reset code
         * @apiName StateReset
         * @apiGroup Auths
         *
         * @apiDescription  Returns the state of reset code as headers Reset-Code-Used and Reset-Code-Valid-At
         *
         * @apiParam {String} Reset-code as header reset-code
         *
         * @apiSuccess {String} Reset-Code-Used 0 - has not been used yet, 1 - has been used
         * @apiSuccess {String}  Reset-Code-Valid-At Date and time is valid for specific reset code
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
         *
         *   Connection →Keep-Alive
         *   Content-Type →application/json; charset=UTF-8
         *   Date →Mon, 02 May 2016 12:25:45 GMT
         *   Keep-Alive →timeout=5, max=100
         *   Reset-Code-Used →0
         *   Reset-Code-Valid-At →2016-05-01 22:11:26
         *   Server →Apache/2.4.7 (Ubuntu)
         *   X-Powered-By →PHP/5.5.9-1ubuntu4.16
         *
         *
         * @apiError 404 Not found <code>404</code>
         *
         * @apiError 400 Bad request <code>400</code> Reset code has been used
         *
         */
        $actions ['state-reset'] = [
            'class' => 'app\controllers\actions\StateResetAction',
            'modelClass' => $this->modelClass,
        ];
        $actions ['options'] = [
            'class' => 'yii\rest\OptionsAction',
            'collectionOptions' => ['POST', 'PUT', 'HEAD', 'OPTIONS'],
        ];
        $actions ['options-auths'] = [
            'class' => 'yii\rest\OptionsAction',
            'collectionOptions' => ['HEAD', 'OPTIONS'],
        ];
        $actions ['options-login'] = [
            'class' => 'yii\rest\OptionsAction',
            'collectionOptions' => ['POST', 'OPTIONS'],
        ];
        $actions ['options-logout'] = [
            'class' => 'yii\rest\OptionsAction',
            'collectionOptions' => ['DELETE', 'OPTIONS'],
        ];


        return $actions;
    }


    /**
     * @return array of HTTP methods verbs
     */
    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['login'] = ['POST'];
        $verbs['logout'] = ['DELETE'];
        $verbs['ask-reset'] = ['POST'];
        $verbs['do-reset'] = ['PUT'];
        $verbs['state-reset'] = ['HEAD'];
        return $verbs;
    }
}
