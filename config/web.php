<?php

use yii\web\Response;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
       
       [
        'class' => 'yii\filters\ContentNegotiator',
            'formats' => 
            [
            'application/json' => Response::FORMAT_JSON,
            'application/xml' => Response::FORMAT_XML,
            ],
        ],
        
        'log',
        ],

    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        
        'formatter' => [
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'defaultTimeZone' => 'UTC',
        ], 

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'aHTBvyRqJP8qC4mN5zgDaje4_ZgKSx_S',
            'parsers'=> [
                'application/json' =>'yii\web\JsonParser'],
        ],
   
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 600,
                ],
            ],
            'useMemcached' => false,
            'keyPrefix' => '',
        ],

        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => false,
            'enableSession' => false,

            'loginUrl' => null,
        ],
        /*
        'errorHandler' => [
          'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
              //send all mails to a file by default. You have to set
              //'useFileTransport' to false and configure a transport
              //for the mailer to send real emails.
              //'useFileTransport' => true,
        ],
        */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' =>  'smtp.gmail.com',
            'username' => 'intersog.labs@gmail.com',
            'password' => 'BynthcjuKf,c',
            'port' => '465',
            'encryption' => 'ssl',
          ],
      ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'cache' => false,
            'showScriptName' => false,
            'rules' => 
            [
                ['class' => 'yii\rest\UrlRule', 
               // 'pluralize' => 'false',
                'controller' => 'auths',
                'extraPatterns' => 
                    ['POST login'    => 'login',
                     'POST reset'    => 'ask-reset',
                     'PUT reset'     => 'do-reset',
                     'HEAD reset'    => 'state-reset',
                     'DELETE logout' => 'logout',
                     'reset' => 'options',
                     '' =>'options-auths',
                     'login' => 'options-login',
                     'logout' => 'options-logout',

                    ]
                ],

                ['class' => 'yii\rest\UrlRule', 
                //'pluralize' => 'false',
                'controller' => 'users',
                ],

                ['class' => 'yii\rest\UrlRule', 
               // 'pluralize' => 'false',
                'controller' => 'albums',
                'extraPatterns' => 
                    ['GET <id:\d+>/images'                   => 'index-images',
                     'GET <id:\d+>/images/<image_id:\d+>'    => 'view-images',
                     'PUT <id:\d+>/images/<image_id:\d+>'    => 'update-images',
                     'POST <id:\d+>/images'                  => 'create-images',
                     'DELETE <id:\d+>/images/<image_id:\d+>' => 'delete-images',
                     '<id:\d+>/images/<image_id:\d+>'        => 'options-images',
                     '<id:\d+>/images/'                      => 'options-images',
                    ]
                ],
           ],
        ],
        
    ],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
