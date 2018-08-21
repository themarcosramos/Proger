<?php
use \kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'proger',
    'language'=>'pt-BR',
    'timezone' => 'America/Sao_paulo',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/login',
    'modules' => [
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
    
            // configurações de formato para exibir cada atributo de data
            'displaySettings' => [
                'date' => 'php:d-M-Y',
                'time' => 'php:H:i:s A',
                'datetime' => 'php:d-m-Y H:i:s A',
            ],
    
            // configurações de formato para salvar cada atributo de data
            'saveSettings' => [
                'date' => 'php:Y-m-d', 
                'time' => 'php:H:i:s',
                'datetime' => 'php:Y-m-d H:i:s',
            ],
    
            // usa automaticamente kartik widgets para cada um dos formatos acima
            'autoWidget' => true,
        ],

        'gridview' =>  [
            'class' => '\kartik\grid\Module',            
            'downloadAction' => 'gridview/export/download',
            //'i18n' => []
        ]
    ],
    'components' => [

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Novosibirsk'
        ],
       
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            
        ],
            
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'enableCookieValidation' => false,
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            //'enableAutoLogin' => true,
            'enableSession' => true,
            'authTimeout' => 5400, //1he30min tem em segundos  de expira a sessão 
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            //'viewPath' => '@backend/mail',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'automaildesenvolvimento@uefs.br',
                'password' => 'rotiersa',
                'port' => '587',
                'encryption' => 'tls',  
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ],
                ],
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

        
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {

   // $config['modules']['gridview'] = 'kartik\grid\Module';
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
