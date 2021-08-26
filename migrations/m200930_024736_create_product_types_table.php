<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_types}}`.
 */
class m200930_024736_create_product_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_types}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->string(100)->notNull(),
            'active' => $this->boolean()->defaultValue(0)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_types}}');

        return true;
    }
}
