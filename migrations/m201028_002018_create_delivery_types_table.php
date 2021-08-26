<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_types}}`.
 */
class m201028_002018_create_delivery_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%delivery_types}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'delivery_type' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_types}}');

        return true;
    }
}
