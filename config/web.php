<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log-reader'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'log-reader' => [
            'class' => 'kriss\logReader\Module',
            //'as login_filter' => UserLoginFilter::class, // to use login filter
            'aliases' => [
                'App' => '@app/runtime/logs/app.log',
                'Purchase' => '@runtime/logs/purchase/purchase.log',
                'Console' => '@console/runtime/logs/app.log',
            ],
            //'defaultTailLine' => 200,
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'SlgukNeEpZn_5ALHwKxbXow3rLU7Pnic',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        // 'errorHandler' => [
        //     // 'errorAction' => 'site/error',
        // ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'info@feriame.com',
                'password' => 'Feria2020',
                'port' => 587,
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['purchase'],
                    'levels' => ['error', 'warning', 'info'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/purchase/purchase.log.' . date('Ymd'), // important
                    'maxLogFiles' => 31,
                    'dirMode' => 0777,
                    'fileMode' => 0777,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['general'],
                    'levels' => ['error', 'warning', 'info'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/general/general.log.' . date('Ymd'), // important
                    'maxLogFiles' => 31,
                    'dirMode' => 0777,
                    'fileMode' => 0777,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' =>
                        [
                            'products',
                            // 'providers',
                            'subproducttypifications',
                            'subproducttypes',
                            'units',
                            'providercontacts',
                            'producttypes',
                            'productmedia',
                            'productimages',
                            'providerimages',
                            'providerdeliveries',
                            'providertaxes',
                            'favorites',
                            'countries',
                            'provinces',
                            'localities',
                            'addresses',
                            'billingparameters',
                            'purchases',
                            'deliverytypes',
                            'contracts',
                            'purchaseorders',
                            'qualifications',
                            'qualificationvotes',
                            'productqualifications',
                            'questions',
                            'contacts',
                        ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'users',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'GET,HEAD exists' => 'exists',
                        'GET,HEAD info' => 'info',
                        'POST,HEAD pushtokens' => 'createpushtokens',
                        'DELETE pushtokens' => 'deletepushtokens',
                        'OPTIONS exists' => 'options',
                        'OPTIONS info' => 'options',
                        'OPTIONS pushtokens' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'providers',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'POST uploadlogo/<id>' => 'uploadlogo',
                        'DELETE <id>/providerdeliveries' => 'deleteproviderdeliveries',
                        'PUT edit' => 'edit',
                        'GET exists' => 'exists',
                        'POST mercadopago' => 'mercadopago',
                        'OPTIONS <id>/providerdeliveries' => 'options',
                        'OPTIONS edit' => 'options',
                        'OPTIONS uploadlogo/<id>' => 'options',
                        'OPTIONS exists' => 'options',
                        'OPTIONS mercadopago' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'products',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'GET,HEAD history' => 'history',
                        'GET,HEAD suggestions' => 'suggestions',
                        'GET,HEAD search' => 'search',
                        'GET,HEAD <id>/see' => 'see',
                        'GET,HEAD <id>/address/<addressesId>' => 'delivery',
                        'GET,HEAD <id>/address/<addressesId>/quantity/<quantity>' => 'delivery',
                        'PUT,HEAD <id>/deliverytypes' => 'deliverytypes',
                        'GET,HEAD <id>/totalscore' => 'totalscore',
                        'GET,HEAD <id>/score' => 'score',
                        'OPTIONS history' => 'options',
                        'OPTIONS suggestions' => 'options',
                        'OPTIONS search' => 'options',
                        'OPTIONS <id>/see' => 'options',
                        'OPTIONS <id>/deliverytypes' => 'options',
                        'OPTIONS <id>/address/<addressesId>' => 'options',
                        'OPTIONS <id>/address/<addressesId>/quantity/<quantity>' => 'options',
                        'OPTIONS <id>/totalscore' => 'options',
                        'OPTIONS <id>/score' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'clients',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'POST register' => 'register',
                        'POST picture' => 'picture',
                        'DELETE picture' => 'deletepicture',
                        'GET,HEAD exists' => 'exists',
                        'GET,HEAD sendoffersmail' => 'sendoffersmail',
                        'PUT,HEAD <id>/interestgroups' => 'interestgroups',
                        'PUT,HEAD avatar' => 'avatar',
                        'PUT,HEAD edit' => 'edit',
                        'GET,HEAD avatars' => 'avatars',
                        'OPTIONS picture' => 'options',
                        'OPTIONS avatar' => 'options',
                        'OPTIONS avatars' => 'options',
                        'OPTIONS edit' => 'options',
                        'OPTIONS register' => 'options',
                        'OPTIONS exists' => 'options',
                        'OPTIONS sendoffersmail' => 'options',
                        'OPTIONS <id>/interestgroups' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'favorites',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'POST add/<id>' => 'add',
                        'OPTIONS add/<id>' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'purchases',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'GET,HEAD client' => 'client',
                        'PUT,HEAD <code>/' => 'updatestatus',
                        'OPTIONS <code>/' => 'options',
                        'OPTIONS client' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'billingparameters',
                    'extraPatterns' => [
                        'POST configure' => 'configure',
                        'OPTIONS configure' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'contracts',
                    'extraPatterns' => [
                        'GET,HEAD client' => 'client',
                        'GET,HEAD provider' => 'provider',
                        'OPTIONS client' => 'options',
                        'OPTIONS provider' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'qualifications',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'POST <code>/' => 'save',
                        'OPTIONS <code>/' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'qualificationvotes',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'POST <id>/save' => 'save',
                        'OPTIONS <id>/save' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'questions',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'POST <id>/answer' => 'answer',
                        'OPTIONS <id>/answer' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'addresses',
                    // 'pluralize' => false
                    'extraPatterns' => [
                        'GET geo/<query>' => 'geo',
                        'OPTIONS geo/<query>' => 'options',
                    ]
                ],
            ],
        ]
    ],
    'params' => $params,
];


if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '172.26.0.1', '138.121.228.13'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}
return $config;
