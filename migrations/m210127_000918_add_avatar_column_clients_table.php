<?php

use yii\db\Migration;

/**
 * Class m210127_000918_add_avatar_column_clients_table
 */
class m210127_000918_add_avatar_column_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'avatar', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210127_000918_add_avatar_column_clients_table cannot be reverted.\n";

        $this->dropColumn('{{%clients}}', 'avatar');

        return true;
    }
}
