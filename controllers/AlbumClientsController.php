<?php

namespace app\controllers;

class AlbumClientsController extends MainController
{
    public $modelClass   = '\app\models\AlbumClients';
    public $modelName    = 'AlbumClients';
    public $searchModelClass  =  '\app\models\AlbumClientsSearch';


    
/**
 * @api {post} /album-clients  Sets client access for album
 * @apiName Gives access to the Album
 * @apiGroup Album Clients
 *
 * @apiDescription  Gives access to the specific Album to the specific client
 * Administrator, Photographer can give access
 *
 * @apiParam {Json} id Id album, Id client like { "album_id" : 16, "user_id : 40}
 * @apiHeader {String} Authorization Users unique access-token like Bearer ..... 
 *
 * @apiSuccess (Success 201 Created) {Json} Album the Album like {key:value,}
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 201 Created
 *     Location:  http://127.0.0.1/interPhoto/web/albums/66
 *        {
 *    "album_id": "16",
 *    "user_id": "40",
 *     "id": 3
 *        }
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
   