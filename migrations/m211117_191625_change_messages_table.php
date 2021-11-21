<?php

use yii\db\Migration;

/**
 * Class m211117_191625_change_messages_table
 */
class m211117_191625_change_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%messages}}', 'updated_at');
        $this->addColumn('{{%messages}}', 'chat_id', 'string');
        $this->alterColumn('{{%messages}}', 'read', $this->integer()->defaultValue(0));
        $this->renameColumn('{{%messages}}','read','read_at');
        $this->createIndex('author1_idx', '{{%messages}}', 'sender_id');
        $this->createIndex('author2_idx', '{{%messages}}', 'receiver_id');
        $this->createIndex('chat_idx', '{{%messages}}', 'chat_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%messages}}', 'updated_at', 'integer');
        $this->dropColumn('{{%messages}}', 'chat_id');
        $this->renameColumn('{{%messages}}','read_at','read');
        $this->alterColumn('{{%messages}}', 'read', $this->boolean());
    }

}
