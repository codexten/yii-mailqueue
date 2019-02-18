<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 4/10/18
 * Time: 4:02 PM
 */

return [
    'gmail' => [
        'class' => '\codexten\yii\mailqueue\MailQueue',
        'useFileTransport' => false,
        'htmlLayout' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => $params['gmail.username'],
            'password' => $params['gmail.password'],
            'port' => 587,
            'encryption' => 'tls',
        ],
    ],
];