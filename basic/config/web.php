<?php
use kartik\mpdf\Pdf;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'defaultRoute' => 'site/index',
    'layout' => 'main',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'PLN49',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['site/login'],
            'enableAutoLogin' => true,
            'autoRenewCookie' => true
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        // 'mailer' => [
        //     'class' => 'yii\swiftmailer\Mailer',
        //     'viewPath' => '@app/mailer',
        //     'useFileTransport' => false,
        //     'transport' => [
        //         'class' => 'Swift_SmtpTransport',
        //         'host' => 'your-host-domain e.g. smtp.gmail.com',
        //         'username' => 'your-email-or-username',
        //         'password' => 'your-password',
        //         'port' => '587',
        //         'encryption' => 'tls',
        //     ],
        // ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' =>  [
                '<controller:\w+>/<id:\d+>' => '<controller>/</action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:dm-report>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:pln-pic>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:service-family>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:support-area>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:support-position>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:support-report>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ]
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
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],    
        ],
        'denyCallback' => function(){
            return Yii::$app->response->redirect(['site/login']);
        }
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    $config['modules']['gridview'] = [
        'class' => 'kartik\grid\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20']
    ];
}

return $config;
