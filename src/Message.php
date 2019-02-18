<?php

/**
 * Message.php
 * @author Saranga Abeykoon http://nterms.com
 */

namespace codexten\yii\mailqueue;

use entero\models\Queue;

/**
 * Extends `yii\swiftmailer\Message` to enable queuing.
 *
 * @see http://www.yiiframework.com/doc-2.0/yii-swiftmailer-message.html
 */
class Message extends \yii\swiftmailer\Message
{
    /**
     * @param string $time_to_send
     *
     * @return bool
     */
    public function queue($time_to_send = 'now')
    {
        if($time_to_send == 'now') {
            $time_to_send = time();
        }

        $item = new \codexten\yii\mailqueue\models\MailQueue();

        $item->subject = $this->getSubject();
        $item->attempts = 0;
        $item->swift_message = base64_encode(serialize($this));
        $item->time_to_send = date('Y-m-d H:i:s', $time_to_send);

        return $item->save();
    }
}
