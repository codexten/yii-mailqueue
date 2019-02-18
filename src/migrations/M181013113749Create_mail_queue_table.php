<?php

namespace codexten\yii\mailqueue\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mail_queue}}`.
 */
class M181013113749Create_mail_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mail_queue}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(255),
            'attempts' => $this->integer(11),
            'last_attempt_time' => $this->integer(11),
            'sent_time' => $this->integer(11),
            'time_to_send' => $this->integer(11),
            'swift_message' => $this->text(),
            'created_at' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail_queue}}');
    }
}
