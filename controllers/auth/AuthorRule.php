<?php
namespace app\controllers\auth;

use yii\rbac\Rule;
use yii\web\NotFoundHttpException;

//check user_id and 'id' from request  
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {

        if (isset($params['model'])) $model = $params['model'];
        
        if (!\Yii::$app->request->getQueryParam('id')) 
            { 
                \Yii::$app->controller->allowId = 'user_id';
                    return true;
            } 

        $id = \Yii::$app->request->getQueryParam('id');
        $model = new \Yii::$app->controller->modelClass;
        
        if (!$modelAsk = $model->findOne($id))
            throw new NotFoundHttpException('Object not found', 404);
        
        \Yii::$app->controller->allowId = 'user_id';
            return $modelAsk->user_id == \Yii::$app->user->identity->id;
    }
    
}
