<?php

use yii\db\Migration;

/**
 * Таблица значений дополнительных параметров (исходя из категорий) по объявлениям  `{{%params}}`.
 */
class m211121_065317_create_params_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%params}}', [
            'id' => $this->primaryKey(),
            'advert_id' => $this->integer()->notNull(),
            'code' => $this->string(32)->notNull(),
            'value' => $this->string(128)->notNull(),
        ]);
        $this->createIndex('adv_par_idx', '{{%params}}', 'advert_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%params}}');
    }
}
