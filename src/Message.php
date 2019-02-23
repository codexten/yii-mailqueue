<?php

namespace codexten\yii\mailqueue;

/**
 * Extends `yii\swiftmailer\Message` to enable queuing.
 *
 * @see http://www.yiiframework.com/doc-2.0/yii-swiftmailer-message.html
 */
class Message extends \yii\swiftmailer\Message
{
    /**
     * @param string $timeToSend
     *
     * @return bool
     */
    public function queue($timeToSend = 'now')
    {
        if ($timeToSend == 'now') {
            $timeToSend = time();
        }

        $item = new \codexten\yii\mailqueue\models\MailQueue();

        $item->subject = $this->getSubject();
        $item->attempts = 0;
        $item->swift_message = base64_encode(serialize($this));
        $item->time_to_send = date('Y-m-d H:i:s', $timeToSend);

        return $item->save();
    }
}
