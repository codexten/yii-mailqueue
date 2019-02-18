<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 18/2/19
 * Time: 4:03 PM
 */

return [
    'components' => [
        // TODO : temp fix, find good solution
        'mailer' => isset($mailer) ? $mailer[$params['mailer']] : [],
    ],
];