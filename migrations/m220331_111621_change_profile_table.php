<?php

use yii\db\Migration;

/**
 * Class m220331_111621_change_profile_table
 */
class m220331_111621_change_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%profiles}}', 'first_name', $this->string()->defaultValue(null));
        $this->alterColumn('{{%profiles}}', 'last_name', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%profiles}}', 'first_name', $this->string()->notNull());
        $this->alterColumn('{{%profiles}}', 'last_name', $this->string()->notNull());
    }

}
