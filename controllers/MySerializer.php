<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\controllers;

use Yii;
//use yii\base\Arrayable;
//use yii\base\Component;
//use yii\base\Model;
//use yii\data\DataProviderInterface;
//use yii\data\Pagination;
//use yii\helpers\ArrayHelper;
//use yii\web\Link;
//use yii\web\Request;
//use yii\web\Response;
use yii\rest\Serializer;

/**
 * Serializer converts resource objects and collections into array representation.
 *
 * Serializer is mainly used by REST controllers to convert different objects into array representation
 * so that they can be further turned into different formats, such as JSON, XML, by response formatters.
 *
 * The default implementation handles resources as [[Model]] objects and collections as objects
 * implementing [[DataProviderInterface]]. You may override [[serialize()]] to handle more types.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MySerializer extends Serializer
{
    /**
     * Serializes the validation errors in a model.
     * @param Model $model
     * @return array the array representation of the errors
     */
   protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(406, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $name,
                'message' => $message,
            ];
        }

        return $result;
    }

}
