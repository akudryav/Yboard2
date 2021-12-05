<?php

use yii\db\Migration;

/**
 * Class m211204_172509_change_adverts_table
 */
class m211204_172509_change_adverts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%adverts}}', 'address', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%adverts}}', 'address');
    }

}
