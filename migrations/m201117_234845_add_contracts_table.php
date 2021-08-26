<?php

use yii\db\Migration;

/**
 * Class m201117_234845_add_contracts_table
 */
class m201117_234845_add_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contracts}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'type' => $this->integer()->notNull(),
            'contract' => $this->text()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201117_234845_add_contracts_table cannot be reverted.\n";

        $this->dropTable('{{%contracts}}');

        return true;
    }

}
