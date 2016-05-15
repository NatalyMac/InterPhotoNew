<?php
namespace app\controllers;


use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use \app\models\AlbumImages;
use app\models\UploadForm;

/**
 * AlbumsController implements the CRUD actions for Albums model.
 */
class AlbumsController extends MainController
{

    public $modelClass = '\app\models\Albums';
    public $modelName = 'Albums';
    public $searchModelClass = '\app\models\AlbumsSearch';
    public $linkedModelClass = '\app\models\AlbumImages';
    public $linkedModelName = 'Images';
    public $uploadModelClass = '\app\models\UploadForm';
    /**
     * @api {get} /albums Index albums
     * @apiName Index Albums
     * @apiGroup Albums
     *
     * @apiDescription Returns the users' albums according users permissions.
     * Administrator can get all albums.
     * Photographer and client only their own (allowed) albums.
     * If photographer or client doesn't have any own or allowed albums index will be empty.
     *
     * @apiParam No
     * @apiParam {String} name  name of the album for filtering like ?name=Wedding
     * @apiHeader {String} Authorization Users unique access-token like Bearer .....
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
    /**
     * Lists all Albums models.
     * @return mixed
     */
    public function actionIndex()
    {
        return parent::actionIndex();
    }

    /**
     * @api {get} /albums/id  View specific album
     * @apiName View Album
     * @apiGroup Albums
     *
     * @apiDescription Returns the unique id album according users permissions.
     * Administrator can view any album.
     * Photographer and client only their own (allowed) albums.
     *
     * @apiParam {Number} ID Album ID
     * @apiHeader {String} Authorization Users unique access-token like Bearer .....
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

    /**
     * Displays a single Albums model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        return parent::actionView();
    }

    /**
     * @api {put} /albums/id  Update specific album
     * @apiName Update Album
     * @apiGroup Albums
     *
     * @apiDescription Updates the unique id album according users permissions.
     * Administrator can update any album.
     * Photographer and client only their own (allowed) albums.
     *
     * @apiParam {Number} ID Album ID
     * @apiParam {Json} name Album name like { "name": "Peoples"}
     * @apiHeader {String} Authorization Users unique access-token like Bearer .....
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

    /**
     * Updates an existing Albums model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        return parent::actionUpdate();
    }


    /**
     * @api {post} /albums  Create new album
     * @apiName Create Album
     * @apiGroup Albums
     *
     * @apiDescription Creates a new album according users permissions.
     * Administrator, Photographer can create album
     *
     * @apiParam {Json} name Album name like { "name": "Animals"}
     * @apiHeader {String} Authorization Users unique access-token like Bearer .....
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
     * Creates a new Albums model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return parent::actionCreate();
    }

    /**
     * @api {delete} /albums/id  Delete specific album
     * @apiName Delete Album
     * @apiGroup Albums
     *
     * @apiDescription Deletes the unique id album according users permissions.
     * Only Administrator can delete any album.
     * Photographer and client are not allowed to action.
     *
     * @apiParam {Number} ID Album ID
     * @apiHeader {String} Authorization Users unique access-token like Bearer .....
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
     * Deletes an existing Albums model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        return parent::actionDelete();
    }

    /**
     * @return array
     */

    public function actions()
    {
        $actions = parent::actions();
        $actions ['options-images'] = [
            'class' => 'yii\rest\OptionsAction',
        ];

        /**
         * @api {get} /albums/id/images/id  View specific image of the specific album
         * @apiName View Image
         * @apiGroup Images
         *
         * @apiDescription Returns the unique id image of the specific album  according users permissions.
         * Administrator can view any image of any album.
         * Photographer and client can view image only of their own (allowed) albums.
         * Photographer gives access  to his own albums  to the client.
         *
         * @apiParam {number} ID_Album Album ID album
         * @apiParam {number} ID_Image ID image
         * @apiHeader {String} Authorization Users unique access-token like Bearer .....
         *
         * @apiSuccess {Json} Image the Image like {key:value,}
         * @apiSuccess {Json} ResizedImages the Resized Images like {key:value,}
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
         *     {
         *         "Image": {
         *         "id": 11,
         *         "album_id": 16,
         *         "image": "users_cache.png",
         *         "created_at": 1462993051
         *     },
         *        "Resized Images": [
         *     [
         *     {
         *       "status": "complete",
         *       "image_id": 11,
         *       "id": 21,
         *       "size": "100",
         *       "origin": "users_cache.png",
         *       "comment": null
         *     },
         *     {
         *       "status": "complete",
         *       "image_id": 11,
         *       "id": 22,
         *       "size": "400",
         *       "origin": "users_cache.png",
         *       "comment": null
         *     }
         *      ]]
         *      }
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
        $actions['view-images'] = [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => $this->modelClass,
            'findModel' => [$this, 'findModelImages']
        ];


        /**
         * @api {put} /albums/id/images/id  Update image
         * @apiDescription Action is not allowed. To update photo you should delete the photo  and create new one.
         * @apiName Update Image
         * @apiGroup Images
         *
         *
         * @apiError Not_allowed <code>405</code> Method is not allowed
         *
         */
        $actions['update-images'] = [
            'class' => 'yii\rest\OptionsAction',
        ];


        /**
         * @api {post} /albums/id/images  Create  image in the specific album
         * @apiName Create Image
         * @apiGroup Images
         *
         * @apiDescription Creates image in the specific album  according users permissions.
         * Administrator can create any image of any album.
         * Photographer can create  image in their own albums. Client doesn't have permission to creat image.
         *
         * @apiParam {file} UploadForm[imageFile] File of image to upload jpg, png. Key of uploding must be UploadForm[imageFile].
         * @apiHeader {String} Authorization Users unique access-token like Bearer .....
         * @apiHeader {String} Content-Type    multipart/form-data
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
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
         *
         * @apiError Internal Server Error <code>500 Probably album id is not correct or doesn't exist
         *
         * @apiErrorExample Error-Response:
         * "name": "Internal Server Error",
         * "message": "Failed to action for unknown reason. Check the id album",
         * "code": 0,
         * "status": 500,
         * "type": "yii\\web\\ServerErrorHttpException"
         *
         */
        $actions['create-images'] = [
            'class' => 'app\controllers\actions\CreateImageAction',
            'modelClass' => $this->uploadModelClass,
        ];

        /**
         * @api {delete} /albums/id/images/id  Delete specific image in the specific album
         * @apiName Delete Image
         * @apiGroup Images
         *
         * @apiDescription Delets the unique id image in the specific album  according users permissions.
         * Administrator can delete any image of any album.
         * Photographer can delete image only of  their own (allowed) albums.
         *
         * @apiParam {number} ID_Album ID album
         * @apiParam {number} ID_Image ID image
         * @apiHeader {String} Authorization Users unique access-token like Bearer .....
         *
         * @apiSuccess (Success 204 No content) Empty
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 204 No content
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
        $actions['delete-images'] = [
            'class' => 'yii\rest\DeleteAction',
            'modelClass' => $this->modelClass,
            'findModel' => [$this, 'findModelImageDelete']
        ];


        /**
         * @api {get} /albums/id/images  Index  image of the specific album
         * @apiName Index Image
         * @apiGroup Images
         *
         * @apiDescription Returns the list if images of the specific album  according users permissions.
         * Administrator can index any image of any album.
         * Photographer and client can index image only of  their own (allowed) albums.
         *
         * @apiParam {number} ID Album ID album
         * @apiParam {String} Status You can check of the resizing image state. Just type ?status-=complete ot status=new. The status=complete means
         * that images was resized
         * @apiHeader {String} Authorization Users unique access-token like Bearer .....
         *
         * @apiSuccess {Json} List of images the Image like {key:value,}
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK
         *       [
         * {
         *   "id": 11,
         *   "album_id": 16,
         *   "image": "users_cache.png",
         *   "created_at": 1462993051
         * },
         * {
         *   "id": 15,
         *   "album_id": 16,
         *   "image": "users_cache.png",
         *   "created_at": 1462994046
         * },
         *
         * @apiSuccessExample Success-Response:
         *     HTTP/1.1 200 OK     ]
         * [
         * {
         *   "image": "users_cache.png",
         *   "id": "11",
         *   "status": "complete"
         * },
         * {
         *   "image": "users_cache.png",
         *   "id": "15",
         *   "status": "complete"
         * },
         * {
         *   "image": "users_cache.png",
         *   "id": "16",
         *   "status": "complete"
         * }
         *]
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

        $actions['index-images'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => [$this, 'prepareDataProviderImages']
        ];
        return $actions;
    }

    /**
     * @return \yii\data\ActiveDataProvider
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function prepareDataProviderImages()
    {
        $params = $this->getFilterParamsImages();
        $modelClass = $this->modelClass;

        if (!($modelClass::findOne($params['id'])))
            throw new NotFoundHttpException('Object not found', 404);

        $searchModel = new \app\models\AlbumImagesSearch;

        return $searchModel->search($params);
    }

    /**
     * @return array og GET query params
     * @throws BadRequestHttpException
     */
    public function getFilterParamsImages()
    {
        $params = \Yii::$app->request->getQueryParams();
        $model = new $this->linkedModelClass;
        $modelAttr = $model->attributes;
        $modelAttr['status'] = null;

        $filter = [];
        $filter['status'] = null;
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (!is_scalar($key) or !is_scalar($value))
                    throw new BadRequestHttpException('400 Bad Request. Parameters are not scalar', 400);
                if (!((in_array(strtolower($key), $this->reservedParams))
                    or ArrayHelper::keyExists($key, $modelAttr, false))
                )
                    throw new BadRequestHttpException('400 Bad Request. Parameters are not allowed or correct', 400);

                $filter[$key] = $value;
            }
        }
        return $filter;
    }


    /**
     * @param integer $id of album,  $image_id
     * @return mixed array of objects AlbumImages and ResizedPhotos
     * @throws NotFoundHttpException
     */
    public function findModelImages()
    {
        if (\Yii::$app->request->queryParams) {
            if ((!$image = AlbumImages::findOne(\Yii::$app->request->queryParams['image_id'])) and
                ($image['album_id'] !== \Yii::$app->request->queryParams['id'])
            )
                throw new NotFoundHttpException($message = "Object not found: "
                    . \Yii::$app->request->queryParams['image_id']);

            $images['Image'] = $image;
            $images['Resized Images'] = [$image->resizedPhotos];
            return $images;
        }
    }

    /**
     * @param integer $id of album,  $image_id
     * @return object of AlbumImages
     * @throws NotFoundHttpException
     */
    public function findModelImageDelete()
    {
        if (\Yii::$app->request->queryParams) {
            if (($image = AlbumImages::findOne(\Yii::$app->request->queryParams['image_id']))
                and
                $image['album_id'] == \Yii::$app->request->queryParams['id']
            ) {
                return $image;

            } else {
                throw new NotFoundHttpException($message = "Object not found: "
                    . \Yii::$app->request->queryParams['image_id']);
            }
        }
    }

}