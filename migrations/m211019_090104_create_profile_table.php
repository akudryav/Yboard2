<?php

use yii\db\Migration;

/**
 * Таблица профилей (доп инфа по пользователям) `{{%profiles}}`.
 */
class m211019_090104_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DROP TABLE IF EXISTS {{%profiles}}');
        $this->createTable('{{%profiles}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'country' => $this->string(),
            'phone' => $this->string(),
            'network' => $this->string(),
            'uid' => $this->string(),
            'company' => $this->string(),
            'birthdate' => $this->integer(),
        ]);
        $this->createIndex('usr_prof_idx', '{{%profiles}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profiles}}');
    }
}
