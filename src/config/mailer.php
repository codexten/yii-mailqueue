<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 4/10/18
 * Time: 4:02 PM
 */

return [
    'gmail' => [
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => false,
        'htmlLayout' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'developer.entero@gmail.com',
            'password' => 'developer.entero!@#',
            'port' => 587,
            'encryption' => 'tls',
        ],
    ],
];