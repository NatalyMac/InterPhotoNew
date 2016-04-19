<?php
namespace app\controllers\auth;

use yii\rbac\Rule;
//use app\models\Albums;

/**
 * Проверяем authorID на соответствие с пользователем, переданным через параметры
 */
class AllowRule extends Rule
{
    public $name = 'isAllow';
    public $allowId = null;

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $user_id = null;
        $id = \Yii::$app->user->identity->id;

        if (isset(\Yii::$app->request->queryParams['user_id'])) 
            $user_id = \Yii::$app->request->queryParams['user_id'];

        if (isset(\Yii::$app->request->queryParams['id'])) { 
            $id_item = \Yii::$app->request->queryParams['id'];
            $model = \Yii::$app->controller->findModelAuthorRule($id_item);
            $user_id = $model->user_id;
        }
           
        \Yii::$app->controller->allowId = 'user_id';    
        
        if (($user_id == $id) or ($user_id == null))
            return true;
        
        if ($user_id !== $id) 
            return false;
    }
}