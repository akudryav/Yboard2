<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%adverts}}`.
 */
class m211108_111034_create_adverts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DROP TABLE IF EXISTS {{%adverts}}');
        $this->createTable('{{%adverts}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(128)->notNull(),
            'location' => $this->string(32)->notNull(),
            'type' => $this->tinyInteger()->notNull()->defaultValue(0),
            'views' => $this->integer()->defaultValue(0),
            'text' => $this->text(),
            'fields' => $this->text(),
            'price' => $this->float(),
            'moderated' => $this->boolean(),
            'created_at' => $this->integer(10)->notNull()->unsigned(),
            'updated_at' => $this->integer(10)->notNull()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%adverts}}');
    }
}
