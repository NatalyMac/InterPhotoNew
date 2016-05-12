<?php
namespace app\controllers\auth;

use yii\rbac\Rule;
use yii\web\NotFoundHttpException;

/**
 * Проверяем authorID на соответствие с пользователем, переданным через параметры
 */
class AllowRule extends Rule
{
    public $name = 'isAllow';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {

        if (isset($params['model'])) $model = $params['model'];
        $model = \Yii::$app->controller->modelClass;  

        $userId =  \Yii::$app->user->identity->id;  

        if (!\Yii::$app->request->getQueryParam('id')) 
            {
              
                \Yii::$app->controller->allowId = 'albums';
                    return true;
            } 

        $model = new \Yii::$app->controller->modelClass;
        $id = \Yii::$app->request->getQueryParam('id');

        if (!$modelAsk = $model->findOne($id))
            throw new NotFoundHttpException('Object not found', 404);

        $userId =  \Yii::$app->user->identity->id;
        $model::getAlbumAllow($id, $userId);
            
            return  $model::getAlbumAllow($id, $userId);
    }
}