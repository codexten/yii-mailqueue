<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 18/2/19
 * Time: 4:03 PM
 */

return [
    'components' => [
        'mailer' => $mailer[$params['mailer']],
        'mailqueue' => $mailer[$params['mailer']],
    ],
];