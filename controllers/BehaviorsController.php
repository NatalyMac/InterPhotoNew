<?php
namespace app\controllers;

use app\models\Users; 
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use app\controllers\components\AccessRule;

class UsersController extends ActiveController