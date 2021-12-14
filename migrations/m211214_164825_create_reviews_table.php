<?php

use yii\db\Migration;

/**
 * Таблица оценок и комментариев `{{%reviews}}`.
 */
class m211214_164825_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DROP TABLE IF EXISTS {{%reviews}}');
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'advert_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'profile_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'reply_to' => $this->integer(),
            'created_at' => $this->integer(10)->notNull()->unsigned(),
        ]);

        $this->addColumn('{{%profiles}}', 'rating_avg', 'float');
        $this->addColumn('{{%profiles}}', 'rating_count', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reviews}}');
        $this->dropColumn('{{%profiles}}', 'rating_avg');
        $this->dropColumn('{{%profiles}}', 'rating_count');
    }
}
