<?php

use yii\db\Migration;

/**
 * Class m211106_102629_change_adverts_table
 */
class m211106_102629_change_adverts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE adverts ADD COLUMN field_tmp INT UNSIGNED');
        $this->execute('UPDATE adverts SET field_tmp = UNIX_TIMESTAMP(created_at)');
        $this->execute('ALTER TABLE adverts DROP created_at');
        $this->execute('alter TABLE adverts CHANGE field_tmp created_at INT UNSIGNED NULL DEFAULT 0');

        $this->execute('ALTER TABLE adverts ADD COLUMN field_tmp INT UNSIGNED');
        $this->execute('UPDATE adverts SET field_tmp = UNIX_TIMESTAMP(updated_at)');
        $this->execute('ALTER TABLE adverts DROP updated_at');
        $this->execute('alter TABLE adverts CHANGE field_tmp updated_at INT UNSIGNED NULL DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE adverts MODIFY created_at datetime');
        $this->execute('ALTER TABLE adverts MODIFY updated_at datetime');
    }

}
