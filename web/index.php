<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
//define('YII_ENABLE_ERROR_HANDLER', false);
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

//(new yii\web\Application($config))->run();
$application = new yii\web\Application($config);

function vd($var, $exit = true)
{
    $dumper = new yii\helpers\BaseVarDumper();
    echo $dumper::dump($var, 10, true);
    if ($exit)
        exit;
}
$application->run();
