<?php
namespace app\controllers;
 
use app\models\Users; 
use app\models\Albums;
use app\controllers\auth\AuthorRule;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\filters\AccessControl;
use app\controllers\MainController;
use yii\web\NotFoundHttpException;
use \app\models\AlbumImages;
use yii2\rest\OptionsAction;
use yii\data\ActiveDataProvider;

class AlbumsController extends MainController
{
    public $modelClass       = '\app\models\Albums';
    public $linkedModelClass = '\app\models\AlbumImages';
    public $searchAttr       = 'AlbumsSearch';
    public $searchModel      = '\app\models\AlbumsSearch';
    public $authModel        = '\app\models\Users';
    //public $nameModel   = '\app\models\Albums';
    public $model            = 'Album';
    public $linkedModel      = 'Images';

/**
 * @api {get} /albums Index albums
 * @apiName Index Albums
 * @apiGroup Album
 *
 * @apiDescription Returns the users' albums according users permissions.
 * Administrator can get all albums.
 * Photographer and client only their own (allowed) albums.
 * 
 * @apiParam No
 *
 * @apiSuccess {Json} List List of the Albums like [{key:value,}, {key:value,}]
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     [
 *        {
 *          "id":43,
 *          "user_id":37,
 *          "name":"album2",
 *           "active":1,
 *           "created_at":"2016-04-18 17:42:56",
 *           "modified_at":"2016-04-19 02:00:25"
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
 * @api {get} /albums/id  View specific album
 * @apiName View Albums
 * @apiGroup Album
 *
 * @apiDescription Returns the inique id album according users permissions.
 * Administrator can view any album.
 * Photographer and client only their own (allowed) albums.
 * 
 * @apiParam {Number} ID Album ID
 *
 * @apiSuccess {Json} Album the Album like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *        {
 *          "id":43,
 *          "user_id":37,
 *          "name":"album2",
 *          "active":1,
 *          "created_at":"2016-04-18 17:42:56",
 *          "modified_at":"2016-04-19 02:00:25"
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

    public function actionView()
    {
        return parent::actionView();
    }

/**
 * @api {put} /albums/id  Update specific album
 * @apiName Update Albums
 * @apiGroup Album
 *
 * @apiDescription Updates the inique id album according users permissions.
 * Administrator can update any album.
 * Photographer and client only their own (allowed) albums.
 * 
 * @apiParam {Number} ID Album ID
 * @apiParam {Json} name Album name like { "name": "Peoples"}
 *
 * @apiSuccess {Json} Album the Album like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *        {
 *          "id":43,
 *          "user_id":37,
 *          "name":"Peoples",
 *           "active":1,
 *           "created_at":"2016-04-18 17:42:56",
 *           "modified_at":"2016-04-19 02:30:25"
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
 * @api {post} /albums  Create new album
 * @apiName Create Albums
 * @apiGroup Album
 *
 * @apiDescription Creates a new album according users permissions.
 * Administrator, Photographer and Client  can create album
 * 
 * @apiParam {Number} ID Album ID
 * @apiParam {Json} name Album name like { "name": "Animals"}
 *
 * @apiSuccess (Success 201 Created) {Json} Album the Album like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 201 Created
 *     Location:  http://127.0.0.1/interPhoto/web/albums/66
 *        {
 *          "name": "Animals",
 *          "user_id": 39,
 *          "id": 66
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
 */
    public function actionCreate()
    {
        return parent::actionCreate();
    }

/**
 * @api {delete} /albums/id  Delete specific album
 * @apiName Delete Albums
 * @apiGroup Album
 *
 * @apiDescription Deletes the inique id album according users permissions.
 * Only Administrator can delete any album.
 * Photographer and client are not allowed to action.
 * 
 * @apiParam {Number} ID Album ID
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
    public function actionDelete()
    {
        return parent::actionDelete();
    }


    public function actions() 
    {   
        $actions = parent::actions();
        $actions ['options-images'] = [
            'class' => 'yii\rest\OptionsAction',
            ];
        $actions['view-images'] = [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => $this->modelClass,
            'findModel' => [$this, 'findModelImages']
            ];       
        $actions['update-images'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => $this->modelClass,
            'findModel' => [$this, 'findModelImages']
            ];       
        $actions['create-images'] = [
            'class' => 'yii\rest\CreateAction',
            'modelClass' => $this->linkedModelClass,
            'findModel' => [$this, 'findModelImages']
            ];       
        $actions['delete-images'] = [
             'class' => 'yii\rest\DeleteAction',
             'modelClass' => $this->linkedModelClass,
             'findModel' => [$this, 'findModelImages']
            ];       
        $actions['index-images'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => [$this, 'prepareDataProviderImages']
            ];       
        return $actions;
    }

    public function prepareDataProviderImages()
    {
        $params = \Yii::$app->request->queryParams['id'];
        $modelClass = $this->modelClass;
            return  $modelClass::findOne($params)->albumImages;
    }

    public function findModelImages()
       {
            if (\Yii::$app->request->queryParams)
        {
            if (($images = AlbumImages::findOne(\Yii::$app->request->queryParams['image_id'])) 
              && 
            $images['album_id'] == \Yii::$app->request->queryParams['id']) 
        {
             return $images;
        } else {  
            throw new NotFoundHttpException($message = "Object not found: " 
                                            . \Yii::$app->request->queryParams['image_id']);
                }
        }
    }


}