<?php

namespace app\controllers;

use app\models\Users;
use yii\web\User; 

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends MainController
{
    public $modelClass = '\app\models\Users';
    public $modelName = 'Users';
    public $searchModelClass = '\app\models\UsersSearch';
    public $registerScenario = Users::SCENARIO_REGISTER;
    public $updateScenario = Users::SCENARIO_UPDATE;

    /**
     * @api {get} /users Index users
     * @apiName Index Users
     * @apiGroup Users
     *
     * @apiDescription Returns the list of the users according users permissions.
     * Administrator can get all users. Photographer and client can index only own information.
     *
     * @apiParam No
     *
     * @apiSuccess {Json} List List of the Users like [{key:value,}, {key:value,}]
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     * {
     *   "id": 37,
     *   "role": "admin",
     *   "name": "mmm",
     *   "email": "travers.nk@gmail.com",
     *   "phone": "10000",
     *   "modified_at": "2016-05-10 15:40:54",
     *   "created_at": "2016-04-18 16:12:09"
     * },
     * {
     *   "id": 39,
     *   "role": "photographer",
     *   "name": "photo",
     *   "email": "photo@gmail.com",
     *   "phone": "000-000-00-00",
     *   "modified_at": "2016-05-10 15:40:49",
     *   "created_at": "2016-04-18 16:14:17"
     * },
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

    /**
     * Lists all Users models.
     * @return mixed
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
     *      {
     *  "id": 37,
     * "role": "admin",
     * "name": "mmm",
     * "email": "travers.nk@gmail.com",
     * "phone": "10000",
     * "modified_at": "2016-05-10 15:40:54",
     * "created_at": "2016-04-18 16:12:09"
     *       }
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

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
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
     * @apiParam {Json} name User name like { "name": "Anna"} add other fields, excluding email and role, email and  is nor allowed to change
     *
     *
     * @apiSuccess {Json} User the User like {key:value,}
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *        {
     *     {
     * "id": 37,
     * "role": "admin",
     * "name": "mmmm",
     * "email": "travers.nk@gmail.com",
     * "phone": "10000",
     * "modified_at": "2016-05-10 15:40:54",
     * "created_at": "2016-04-18 16:12:09"
     *    }
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
        var_dump('ffff');
          return  parent::actionUpdate();
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
     *   {
     *    "name": "mmmm",
     *    "email": "s@s.v",
     *    "role": "admin",
     *    "id": 103
     *     }
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

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    

    public function actions()
    {
        var_dump('ssss');
        var_dump(\Yii::$app->user->identity);
        $actions = parent::actions();
        $actions['create'] = [
            'class' => 'yii\rest\CreateAction',
            'modelClass' => $this->modelClass,
            'scenario' => $this->registerScenario,
        ];
        /**
         * Updates an existing Users model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */

        $actions['update'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => $this->modelClass,
            'scenario' => $this->updateScenario,
        ];
        
        return $actions;
    }
    // для апдейта нужно вводить два сценария, админ и юзер, в одном разрешать смену роли и email, в другом запретить
    // сейчас смена email и роли запрещена сценарием update, чтобы ввести сценарий  нужно переопределить полностью  класс UpdateAction?
    // при update  public function actionUpdate() не задействован, действие происходит в  public function actions()
    // если в  public function actions() определять сценарий для update, то \Yii::$app->user->identity еще NULL, 
    // user identity определится непосредственно в классе UpdateAction. Т.е. полностью переписать UpdateActionClass?
    // остался вопрос

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

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        return parent::actionDelete();
    }

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