<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%units}}`.
 */
class m200930_030226_create_units_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%units}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'type' => "ENUM('V', 'W')",
            'name' => $this->string(30)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%units}}');

        return true;
    }
}
