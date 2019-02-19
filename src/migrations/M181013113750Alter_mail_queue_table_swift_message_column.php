<?php

namespace codexten\yii\mailqueue\migrations;

use yii\db\Migration;
use yii\db\mssql\Schema;

/**
 * Class M181013113750Alter_mail_queue_table_swift_message_column
 *
 * @package codexten\yii\mailqueue\migrations
 */
class M181013113750Alter_mail_queue_table_swift_message_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%mail_queue}}', 'swift_message', 'LONGTEXT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%mail_queue}}', 'swift_message', Schema::TYPE_TEXT);
    }
}
