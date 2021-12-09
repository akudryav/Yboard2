<?php

use yii\db\Migration;

/**
 * Class m211209_091757_change_profile_table
 */
class m211209_091757_change_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%profiles}}','country','city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%profiles}}','city','country');
    }

}
