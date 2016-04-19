<?php
namespace app\controllers\auth;

use yii\rbac\Rule;

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
   
        $id = \Yii::$app->request->queryParams['id'];
        
        $model = \Yii::$app->controller->findModelAuthorRule($id);
            
            return $model->user_id === $user;
    }
}
