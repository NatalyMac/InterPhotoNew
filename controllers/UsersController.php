<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth; 
use app\models\Users; 
use app\controllers\MainController;
use app\controllers\auth\LoginAction;

class UsersController extends MainController
{
    public $modelClass       = '\app\models\Users';
    public $modelName        = 'Users';
    public $searchModelClass = '\app\models\UsersSearch';
    public $searchModelName  = 'UsersSearch';
    
    
/**
 * @api {get} /users Index users
 * @apiName Index Users
 * @apiGroup Users
 *
 * @apiDescription Returns the list of the users according users permissions.
 * Administrator can get all users. Photographer and client can index only own information
 * 
 * @apiParam No
 *
 * @apiSuccess {Json} List List of the Users like [{key:value,}, {key:value,}]
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     [
 *        {
 *          to do 
 *         },
 *          {
 *           .......
 *          }
 *        ]
 *
 * @apiError Unauthorized <code>401</code> User needs to be autorized to action
 *
 * @apiErrorExample Error-Response:
 *     401 Unauthorized
 *     {
 *        "name":"Unauthorized",
 *        "message":"You are requesting with an invalid credential.",
 *        "code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"
 *     }
 */
    public function actionIndex()
    {
        return parent::actionIndex();
    }

/**
 * @api {get} /users/id  View specific user
 * @apiName View User
 * @apiGroup Users
 *
 * @apiDescription Returns the unique ID user according users permissions.
 * Administrator can view any user.
 * Photographer and client only their own user information.
 * 
 * @apiParam {Number} ID User ID
 *
 * @apiSuccess {Json} User the User like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *        {
 *          to do 
 *         }
 *
 * @apiError Unauthorized <code>401</code> User needs to be autorized to action
 *
 * @apiErrorExample Error-Response:
 *     401 Unauthorized
 *     {
 *        "name":"Unauthorized",
 *        "message":"You are requesting with an invalid credential.",
 *        "code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"
 *     }
*
 * @apiError Forbidden <code>403</code> User's not allowed to action
 *
 * @apiErrorExample Error-Response:
 *     403 Forbidden
 *     {
 *        "name": "Forbidden",
 *        "message": "You are not allowed to perform this action.",
 *        "code": 0,
 *        "status": 403,
 *        "type": "yii\\web\\ForbiddenHttpException"
 *       }
 */

    public function actionView()
    {
        return parent::actionView();
    }

/**
 * @api {put} /users/id  Update specific user
 * @apiName Update User
 * @apiGroup Users
 *
 * @apiDescription Updates the unique id user according users permissions.
 * Administrator can update any user.
 * Photographer and client only their own user information.
 * 
 * @apiParam {Number} ID User ID
 * @apiParam {Json} name User name like { "name": "Anna"} add other fields
 * 
 *
 * @apiSuccess {Json} User the User like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *        {
 *          to do
 *         }
 *
 * @apiError Unauthorized <code>401</code> User needs to be autorized to action
 *
 * @apiErrorExample Error-Response:
 *     401 Unauthorized
 *     {
 *        "name":"Unauthorized",
 *        "message":"You are requesting with an invalid credential.",
 *        "code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"
 *     }
 * @apiError Forbidden <code>403</code> User's not allowed to action
 *
 * @apiErrorExample Error-Response:
 *     403 Forbidden
 *     {
 *        "name": "Forbidden",
 *        "message": "You are not allowed to perform this action.",
 *        "code": 0,
 *        "status": 403,
 *        "type": "yii\\web\\ForbiddenHttpException"
 *       }
 */
    public function actionUpdate()
    {
        return parent::actionUpdate();
    }

    
/**
 * @api {post} /albums  Create new user
 * @apiName Create User
 * @apiGroup Users
 *
 * @apiDescription Creates a new user according users permissions.
 * Only Administrator can create user
 * 
 * @apiParam {Number} ID User ID
 * @apiParam {Json} name User name like { "name": "Anna"}
 * @apiParam {Json} email User email like { "email": "Anna@a.com"}
 * @apiParam {Json} password  User like { "password": "Anna"}
 *
 * @apiSuccess (Success 201 Created) {Json} User the User like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 201 Created
 *     Location:  http://127.0.0.1/interPhoto/web/albums/66
 *        {
    to do
 *         }
 *
 * @apiError Unauthorized <code>401</code> User needs to be autorized to action
 *
 * @apiErrorExample Error-Response:
 *     401 Unauthorized
 *     {
 *        "name":"Unauthorized",
 *        "message":"You are requesting with an invalid credential.",
 *        "code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"
 *     }
 * 
 * @apiErrorExample Error-Response:
 *     403 Forbidden
 *     {
 *        "name": "Forbidden",
 *        "message": "You are not allowed to perform this action.",
 *        "code": 0,
 *        "status": 403,
 *        "type": "yii\\web\\ForbiddenHttpException"
 *       }
 */
    public function actionCreate()
    {
        return parent::actionCreate();
    }

/**
 * @api {delete} /users/id  Delete specific user
 * @apiName Delete User
 * @apiGroup Users
 *
 * @apiDescription Deletes the unique id user according users permissions.
 * Only Administrator can delete any user.
 * Photographer and client are not allowed to action.
 * 
 * @apiParam {Number} ID User ID
 *
 * @apiSuccess (Success 204 No content) Empty
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 204 No content
 *       
 *
 * @apiError Unauthorized <code>401</code> User needs to be autorized to action
 *
 * @apiErrorExample Error-Response:
 *     401 Unauthorized
 *     {
 *        "name":"Unauthorized",
 *        "message":"You are requesting with an invalid credential.",
 *        "code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"
 *     }
 * @apiError Forbidden <code>403</code> User's not allowed to action
 *
 * @apiErrorExample Error-Response:
 *     403 Forbidden
 *     {
 *        "name": "Forbidden",
 *        "message": "You are not allowed to perform this action.",
 *        "code": 0,
 *        "status": 403,
 *        "type": "yii\\web\\ForbiddenHttpException"
 *       }
 */


}



























































    /* на память ;)))
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // ACF filter for checking user access
        $behaviors['access'] = 
           [
            'class' => AccessControl::className(),
            // check roles AccessRules
            'ruleConfig' => ['class' => AccessRules::className(),],
            'only' => ['create', 'update', 'delete','view','index',],
                'rules' => 
                [
                    [
                    'actions' => ['create',],
                    'allow' => true,
                    'roles' => ['admin','photographer','client'],
                    ],
                    [
                    'actions' => ['update','view',],
                    'allow' => true,
                    'roles' => ['admin', 'photographer','client',],
                    'matchCallback' => function ($rule, $action)
                        {
                            if ($this->isAdmin() or $this->isOwner())
                                return true;
                        }
                    ],
                    [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['photographer','client','admin'],
                    'matchCallback' => function ($rule, $action)
                        {
                            if ($this->isAdmin()) 
                                   return true;
                            if (!$this->isAdmin() and 
                               (isset(\Yii::$app->request->queryParams["id"])))
                                   return false;
                            $this->allowId = 'id';
                                   return true;
                        }
                    ], 
                    [
                        'actions' => ['delete',],
                        'allow' => true,
                        'roles' => ['admin'],
                       
                    ],
                ],//rules
        ];

        return $behaviors;
    }

    public function isAdmin()
    {
         if  (\Yii::$app->user->identity->role ==='admin')
                        return true;
    }

    public function isOwner()
    {
        if ((int) \Yii::$app->user->identity->id === (int) \Yii::$app->request->queryParams['id'])
                        return true;
    }
*/