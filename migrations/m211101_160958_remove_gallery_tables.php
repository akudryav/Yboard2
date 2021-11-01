<?php

use yii\db\Migration;

/**
 * Class m211101_160958_remove_gallery_tables
 */
class m211101_160958_remove_gallery_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%gallery_images}}');
        $this->dropTable('{{%gallery}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211101_160958_remove_gallery_tables cannot be reverted.\n";

        return false;
    }

}
