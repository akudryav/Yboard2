<?php

use yii\db\Migration;

/**
 * Class m211110_171247_load_data
 */
class m211110_171247_load_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(file_get_contents(__DIR__ . '/category.sql'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211110_171247_load_data cannot be reverted.\n";

        return false;
    }

}
